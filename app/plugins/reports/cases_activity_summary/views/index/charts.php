<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php if ($show_new && $show_updated): ?>
	<?php $bars_per_group = 2 ?>
<?php else: ?>
	<?php $bars_per_group = 1 ?>
<?php endif ?>
<?php $chart_height = max(count($case_groups) * ((22 * $bars_per_group) + 3) + 120, 170) ?>
<?php
$categories = tests::getFormattedLabelsForFC($case_groups, true);

$title = '';
if ($changes_from && $changes_to) {
    $title = langf(
        'reports_cas_charts_bar_title_from_to',
        h($case_groupby_name),
        date::format_short_date($changes_from),
        date::format_short_date($changes_to)
    );
} elseif ($changes_from) {
    $title = langf(
        'reports_cas_charts_bar_title_from',
        h($case_groupby_name),
        date::format_short_date($changes_from)
    );
} elseif ($changes_to) {
    $title = langf(
        'reports_cas_charts_bar_title_to',
        h($case_groupby_name),
        date::format_short_date($changes_to)
    );
} else {
    $title = langf('reports_cas_charts_bar_title',
        h($case_groupby_name)
    );
}

$series = [];
$updated_data = [];
$new_data = [];
$largest_value = 0;
foreach ($case_groups as $group_id => $group_name) {
    if ($show_updated) {
        $updated_data[] = [
            'value' => arr::get($cases_updated->case_counts, $group_id, 0)
        ];
    }
    if ($show_new) {
        $new_data[] = [
            'value' => arr::get($cases_created->case_counts, $group_id, 0)
        ];
    }
}

if ($show_updated) {
    $series[] = [
        'seriesname' => lang('reports_cas_charts_legend_updated'),
        'color' => '#8bbc21',
        'data' => $updated_data
    ];

    if (is_array($cases_updated->case_counts)
        && !empty($cases_updated->case_counts)
        && max($cases_updated->case_counts) > $largest_value
    ) {
        $largest_value = max($cases_updated->case_counts);
    }
}

if ($show_new) {
    $series[] = [
        'seriesname' => lang('reports_cas_charts_legend_created'),
        'color' => '#2f7ed8',
        'data' => $new_data
    ];

    if (is_array($cases_created->case_counts)
        && !empty($cases_created->case_counts)
        && max($cases_created->case_counts) > $largest_value
    ) {
        $largest_value = max($cases_created->case_counts);
    }
}

if (!empty($report->id)) {
    $dataSource = [
        'type' => 'msbar2d',
        'height' => $chart_height,
        'width' => 900,
        'dataSource' => [
            'chart' => [
                'caption' => $title,
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
            'categories' => [
                ['category' => $categories]
            ],
            'dataset' => $series
        ]
    ];

    if (!empty($largest_value)) {
        $dataSource['dataSource']['chart']['yAxisMaxValue'] = $largest_value;
    }

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
					caption: '<?php echo  $title ?>',
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
                    chartBottomMargin: '0',
					<?php echo  $largest_value ? 'yAxisMaxValue: ' . $largest_value : '';  ?>
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
