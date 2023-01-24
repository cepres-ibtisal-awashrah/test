<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
if ($show_comparison && $show_summary) {
    $title = lang('reports_cds_charts_bar_title_full');
} else if ($show_comparison) {
    $title = lang('reports_cds_charts_bar_title_comparison');
} else {
    $title = lang('reports_cds_charts_bar_title_summary');
}

$data = [];
$categories = [];
if ($show_comparison) {
    foreach ($runs_reversed as $run) {
        $data_name = h($run->name);
        if ($run->config) {
            $data_name .= '('.$run->config.')';
        }
        $data[] = ['value' => $run->defect_count];
        $categories[] = ['label' => $data_name];
    }
    if ($show_summary) {
        $data[] = ['value' => $summary->defect_count];
        $categories[] = ['label' => lang('reports_cds_defects_summary')];
    }
} else {
    $data[] = ['value' => $summary->defect_count];
    $categories[] = ['label' => lang('reports_cds_defects')];
}

$series[] = [
    'seriesname' => 'Defects',
    'color' => '#7CB5EC',
    'data' => $data
];

if (!empty($report->id)) {
    $dataSource = [
        'type' => $show_comparison ? 'mscolumn2d' : 'msbar2d',
        'creditLabel' => false,
        'height' => 250,
        'width' => 900,
        'dataSource' => [
            'chart' => [
                'caption' => html_entity_decode($title),
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
                'maxColWidth' => 30,
                'showLegend' => false,
                'chartBottomMargin' => 0
            ],
            'categories' => [
                ['category' => $categories]
            ],
            'dataset' => $series
        ]
    ];

    $encodedImage = $report_obj->jsonToImage(
        json_encode($dataSource),
        $report->path
    );
}
?>

<div class="chartContainer">
	<div id="chart0"><?php echo  $encodedImage ?? '' ?></div>
</div>

<script type="text/javascript">
var chart_bar;

$(function () {
	$(document).ready(function() {
		let CHART_TYPE = '<?php echo  $show_comparison ? "mscolumn2d" : "msbar2d" ?>';
		chart_bar = new FusionCharts({
			type: CHART_TYPE,
			renderAt: 'chart0',
			width: '100%',
			height: '100%',
			dataSource: {
				chart: {
					caption: '<?php echo  html_entity_decode($title) ?>',
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
					maxColWidth: '30',
					showLegend: false,
					plotToolText:`<b> $seriesName  </b> <br> $label : $value`,
					interactiveLegend: false,
					chartBottomMargin: '0'
				},
				categories: [{
					category: <?php echo  json_encode($categories) ?>
				}],
				dataset: <?php echo  json_encode($series) ?>
			}
		}).render();
	});
});
</script>
