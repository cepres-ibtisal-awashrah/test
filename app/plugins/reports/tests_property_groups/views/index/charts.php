<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $chart_height = max(count($test_groups) * 25 + 90, 150) ?>
<?php
$bar_chart_data = [];
foreach ($test_groups ?? [] as $group) {
    $status = $GI->cache->get_object('status', $group->id);
    $group_label = $test_groupby === 'tests:status_id'
        ? $group->label
        : $group->name;

    if ($status) {
        $bar_chart_data[] = [
            'label' => h($group_label),
            'color' => color::format($status->color_dark),
            'value' => $group->test_count
        ];
    }
}

if (!empty($report->id)) {
    $dataSource = [
        'type' => 'bar2d',
        'creditLabel' => false,
        'height' => $chart_height,
        'width' => 900,
        'dataSource' => [
            'chart' => [
                'caption' => langf('reports_tpg_charts_bar_title', h($test_groupby_name)),
                'theme' => 'fusion',
                'baseFont' => 'Barlow',
                'baseFontSize' => '14',
                'baseFontColor' => '#4D4D4D',
                'captionFontSize' => 14,
                'maxBarHeight' => 20,
                'yAxisValuesPadding' => 0,
                'reverseLegend' => 1
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
					caption: '<?php echo  langf('reports_tpg_charts_bar_title', h($test_groupby_name)) ?>',
					theme: 'fusion',
					baseFont: 'Barlow',
					baseFontSize: '14',
					baseFontColor: '#4D4D4D',
					captionFontSize: '14',
					maxBarHeight: '20',
					yAxisValuesPadding: '0',
					reverseLegend: '1'
				},
				data: <?php echo  json_encode($bar_chart_data) ?>
			}
		}).render();
	});
});

</script>
