<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $users_to_include = array() ?>
<?php foreach ($users as $user): ?>
	<?php $estimate = arr::get($user_estimates, $user->id) ?>
	<?php if ($estimate && $estimate->test_count): ?>
		<?php $users_to_include[] = $user ?>
	<?php endif ?>
<?php endforeach ?>

<?php $chart_height = max(count($users_to_include) * 65 + 100, 150) ?>
<?php
$categories = [];
$tests = [];
$estimates = [];
$forecasts = [];
foreach ($users_to_include ?? [] as $user) {
    $categories[] = [
        'label' => h(names::shorten($user->name))
    ];

    $estimate = arr::get($user_estimates, $user->id);
    if ($estimate) {
        $tests[] = [
            'value' => $estimate->test_count
        ];
        $estimates[] = [
            'value' => round($estimate->total_estimate / 3600)
        ];
        $forecasts[] = [
            'value' => round($estimate->total_forecast / 3600)
        ];
    }
}

$series[] = [
    'seriesname' => lang('reports_uws_users_tests'),
    'color' => '#7CB5EC',
    'data' => $tests
];
$series[] = [
    'seriesname' => lang('reports_uws_users_estimate'),
    'color' => '#000000',
    'data' => $estimates
];
$series[] = [
    'seriesname' => lang('reports_uws_users_forecast'),
    'color' => '#90ED7D',
    'data' => $forecasts
];

if (!empty($report->id)) {
    $dataSource = [
        'type' => 'msbar2d',
        'creditLabel' => false,
        'height' => $chart_height,
        'width' => 900,
        'dataSource' => [
            'chart' => [
                'caption' => lang('reports_uws_charts_bar_title'),
                'theme' => 'fusion',
                'baseFont' => 'Barlow',
                'baseFontSize' => '14',
                'baseFontColor' => '#4D4D4D',
                'maxBarHeight' => 20,
                'captionFontSize' => 14,
                'yAxisValuesPadding' => 0,
                'reverseLegend' => 1,
                'chartBottomMargin' => 0,
                'plotSpacePercent'=> 9
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
	<div id="chart0" style="height: <?php echo  $chart_height ?>px;"><?php echo  $encodedImage ?? '' ?></div>
</div>

<script type="text/javascript">
var chart_bar;

$(function () {
	$(document).ready(function() {
		chart_bar = new FusionCharts({
			type: 'msbar2d',
			renderAt: 'chart0',
			width: '100%',
			height: '100%',
			dataSource: {
				chart: {
					caption: '<?php echo  lang('reports_uws_charts_bar_title') ?>',
					theme: 'fusion',
					baseFont: 'Barlow',
					baseFontSize: '14',
					baseFontColor: '#4D4D4D',
					captionFontSize: '14',
					maxBarHeight: '20',
					yAxisValuesPadding: '0',
					reverseLegend: '1',
					plotSpacePercent: '9',
					interactiveLegend: false,
					chartBottomMargin: '0'
				},
				categories: [{
					category: <?php echo  json_encode($categories); ?>
				}],
				dataset: <?php echo  json::encode($series) ?>
			}
		}).render();
	});
});

</script>
