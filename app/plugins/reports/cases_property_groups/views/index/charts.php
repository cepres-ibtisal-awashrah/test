<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $chart_height = count($case_groups) * 23 + 80; ?>
<?php
$bar_chart_data = [];
foreach ($case_groups ?? [] as $group) {
    $bar_chart_data[] = [
        'label' => h($group->name),
        'value' => $group->case_count
    ];
}

if (!empty($report->id)) {
    $dataSource = [
        'type' => 'bar2d',
        'creditLabel' => false,
        'width' => 900,
        'height' => $chart_height,
        'dataSource' => [
            'chart' => [
                'caption' => langf('reports_cpg_charts_bar_title', h($case_groupby_name)),
                'paletteColors' => '#7CB5EC',
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
                'chartBottomMargin' => 0
            ],
            'data' => $bar_chart_data
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
		chart_bar = new FusionCharts({
			type: 'bar2d',
			renderAt: 'chart0',
			width: '100%',
			height: '100%',
			dataSource: {
				chart: {
					caption: '<?php echo  langf('reports_cpg_charts_bar_title', h($case_groupby_name)) ?>',
					paletteColors: '#7CB5EC',
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
					chartBottomMargin: '0'
				},
				data: <?php echo  json_encode($bar_chart_data) ?>
			}
		}).render();
	});
});

</script>
