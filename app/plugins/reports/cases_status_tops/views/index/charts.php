<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $chart_height = max(count($statuses) * 23 + 120, 150) ?>

<?php $statuses_reversed = array_reverse($statuses) ?>
<?php
$bar_chart_data = [];
foreach ($statuses_reversed ?? [] as $status) {
    $bar_chart_data[] = [
        'seriesname' => h($status->label),
        'color' => color::format($status->color_dark),
        'data' => [[ 'value' => arr::get($status_totals, $status->id, 0) ]]
    ];
}

if (!empty($report->id)) {
    $categories = [
            ['label' => '']
    ];
    $dataSource = [
        'type' => 'msbar2d',
        'creditLabel' => false,
        'width' => 900,
        'height' => $chart_height,
        'dataSource' => [
            'chart' => [
                'caption' => lang('reports_cst_charts_bar_title'),
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
                'showLabels' => true,
                'chartBottomMargin' => 0
            ],
            'categories' => [
                ['category' => $categories]
            ],
            'dataset' => $bar_chart_data
        ]
    ];

    $encodedImage = $report_obj->jsonToImage(
        json_encode($dataSource),
        $report->path
    );
}
?>

<div class="chartContainer">
    <div id="chart0" style="height: <?php echo  $chart_height ?>px;"><?php echo  $encodedImage ?? '' ?></div>
</div>

<script type="text/javascript">
var chart_bar;

$(function () {
	$(document).ready(function() {
		let CATEGORY_ARRAY = [{
			label: ''
		}];

		chart_bar = new FusionCharts({
			type: 'msbar2d',
			renderAt: 'chart0',
			width: '100%',
			height: '100%',
			dataSource: {
				chart: {
					caption: '<?php echo  lang('reports_cst_charts_bar_title') ?>',
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
					interactiveLegend: false,
					chartBottomMargin: '0'
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
