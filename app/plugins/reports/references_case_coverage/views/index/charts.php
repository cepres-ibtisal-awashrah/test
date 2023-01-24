<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php if ($references && $references->reference_count > 0): ?>
<?php
    $pie_chart_data[] = [
        'label' => lang('reports_rcc_charts_pie_covered'),
        'value' => $references->reference_count_covered,
        'color' => '#7CB5EC'
    ];
    $pie_chart_data[] = [
        'label' => lang('reports_rcc_charts_pie_notcovered'),
        'value' => $references->reference_count_notcovered,
        'color' => '#434343'
    ];

    $bar_chart_data[] = [
        'seriesname' => lang('reports_rcc_charts_bar_references'),
        'data' => [['value' => $references->reference_count]],
        'color' => '#90ED7D'
    ];
    $bar_chart_data[] = [
        'seriesname' => lang('reports_rcc_charts_bar_cases_refs'),
        'data' => [['value' => $references->case_count]],
        'color' => '#F7A35C'
    ];
    if (!empty($noreferences)) {
        $bar_chart_data[] = [
            'seriesname' => lang('reports_rcc_charts_bar_cases_norefs'),
            'data' => [['value' => $noreferences->case_count]],
            'color' => '#8085E9'
        ];
    }

    if (!empty($report->id)) {
        $dataSource = [
            'type' => 'pie2d',
            'creditLabel' => false,
            'width' => 250,
            'height' => 250,
            'dataSource' => [
                'chart' => [
                    'caption' => lang('reports_rcc_charts_pie_title'),
                    'theme' => 'fusion',
                    'baseFont' => 'Barlow',
                    'baseFontSize' => '14',
                    'baseFontColor' => '#4D4D4D',
                    'captionFont' => 'Barlow',
                    'captionFontSize' => '14',
                    'captionFontColor' => '#4D4D4D',
                    'showValues' => true,
                    'showLabels' => false,
                    'captionPadding' => 0,
                    'chartLeftMargin' => 0,
                    'chartRightMargin' => 0,
                    'chartTopMargin' => 0,
                    'interactiveLegend' => false,
                    'chartBottomMargin' => 0
                ],
                'data' => $pie_chart_data
            ]
        ];

        $encodedPieImage = $report_obj->jsonToImage(
            json_encode($dataSource),
            $report->path
        );

        $categories = [
            ['label' => '']
        ];

        $dataSource = [
            'type' => 'msbar2d',
            'creditLabel' => false,
            'width' => 600,
            'height' => 250,
            'dataSource' => [
                'chart' => [
                    'caption' => lang('reports_rcc_charts_bar_title'),
                    'theme' => 'fusion',
                    'baseFont' => 'Barlow',
                    'baseFontSize' => '14',
                    'baseFontColor' => '#4D4D4D',
                    'yAxisValueFont' => 'Barlow',
                    'yAxisValueFontSize' => '14',
                    'yAxisValueFontColor' => '#4D4D4D',
                    'captionFont' => 'Barlow',
                    'captionFontSize' => '14',
                    'captionFontColor' => '#4D4D4D',
                    'showValues' => true,
                    'showLabels' => false,
                    'interactiveLegend' => false,
                    'chartBottomMargin' => 0
                ],
                'categories' => [
                    ['category' => $categories]
                ],
                'dataset' => $bar_chart_data
            ]
        ];

        $encodedBarImage = $report_obj->jsonToImage(
            json_encode($dataSource),
            $report->path
        );
    }
?>

<div class="chartContainer">
    <div class="float-left">
        <div id="chart0"><?php echo  $encodedPieImage ?? '' ?></div>
    </div>
    <div class="float-right">
        <div id="chart1"><?php echo  $encodedBarImage ?? '' ?></div>
    </div>	
    <div class="clear-float"></div>
</div>

<script type="text/javascript">
var chart_pie, chart_bar;

$(function () {
	$(document).ready(function() {
		chart_pie = new FusionCharts({
			type: 'pie2d',
			renderAt: 'chart0',
			width: '100%',
			height: '100%',
			dataSource: {
				chart: {
					caption: '<?php echo  lang('reports_rcc_charts_pie_title') ?>',
					theme: 'fusion',
					baseFont: 'Barlow',
					baseFontSize: '14',
					baseFontColor: '#4D4D4D',
					showValues: true,
					showLabels: false,
					captionFont: 'Barlow',
					captionFontSize: '14',
					captionFontColor: '#4D4D4D',
					captionPadding : '0',
					chartLeftMargin : '0',
					chartRightMargin : '0',
					chartTopMargin : '0',
					chartBottomMargin : '0',
					interactiveLegend: false,
					plotToolText:`<strong>$label</strong> <br />$value`
				},
				data: <?php echo  json_encode($pie_chart_data) ?>
			}
		}).render();

		let CATEGORY_ARRAY = [{
			label: ''
		}];

		chart_bar = new FusionCharts({
			type: 'msbar2d',
			renderAt: 'chart1',
			width: '100%',
			height: '100%',
			dataSource: {
				chart: {
					caption: '<?php echo  lang('reports_rcc_charts_bar_title') ?>',
					theme: 'fusion',
					baseFont: 'Barlow',
					baseFontSize: '14',
					baseFontColor: '#4D4D4D',
					yAxisValueFont: 'Barlow',
					yAxisValueFontSize: '14',
					yAxisValueFontColor: '#4D4D4D',
					captionFont: 'Barlow',
					captionFontSize: '14',
					captionFontColor: '#4D4D4D',
					showValues: true,
					showLabels: false,
					chartBottomMargin : '0',
					interactiveLegend: false
				},
				categories: [{
					category: CATEGORY_ARRAY
				}],
				dataset: <?php echo  json_encode($bar_chart_data) ?>
			}
		}).render();
	});
});
</script>
<?php endif ?>