/*******************************************************************/
/* Export (CSV/Excel)  */

App.ExportCsv = function(o)
{
	var self = this;

	self.format = o.format;
	self.init = o.init;

	self.open = function()
	{
		App.Validation.hideErrors();
		self._reset();

		$('#exportCsvForm').unbind('submit').submit(
			function()
			{
				App.Validation.hideErrors();

				var values = self._getValues();
				if (!values)
				{
					return false;
				}

				// We build/fill a second form with our values/control
				// to submit and then close this dialog.
				$('#exportCsvExportFormat').val(self.format);
				$('#exportCsvExportSectionIDs').val(values.section_ids.join(','));
				$('#exportCsvExportSectionInclude').val(values.section_include);
				$('#exportCsvExportColumns').val(values.columns.join(','));
				$('#exportCsvExportLayout').val(values.layout);
				$('#exportCsvExportSeparatorHint').val(values.separator_hint ? '1' : '0');
				$('#exportCsvExportSeparatedStepsNewLines').val(values.separated_steps_new_lines ? '1' : '0');
				$('#exportCsvExportForm').submit();

				App.Dialogs.closeTop();
				return false; // Cancel submit for main form
			}
		);

		App.Dialogs.open(
		{
			selector: '#exportCsvDialog',
			titleSelector: '.' + self.format
		});

		if (self.init)
		{
			self.init();
		}
	}

	self._getValues = function()
	{
		var section_include =
			$('#exportCsvDialog input[name=exportCsvSections]:checked').val();
		var section_ids = Array();

		if (section_include == 'selected')
		{
			section_ids = $('#exportCsvSectionsSelection').val();
			if (!section_ids || !section_ids.length)
			{
				$('#exportCsvErrorNoSection').show();
				return null;
			}
		}

		var columns = App.Controls.Checkboxes.getValuesAsString(
			'exportCsvColumns'
		);

		if (!columns || !columns.length)
		{
			$('#exportCsvErrorNoColumn').show();
			return null;
		}

		return {
			section_include: section_include,
			section_ids: section_ids,
			columns: columns,
			layout: $('#exportCsvLayout').val(),
			separator_hint: $('#exportCsvSeparatorHint').is(':checked'),
			separated_steps_new_lines: $('#exportCsvSeparatedStepsNewLines').is(':checked')
		};
	}

	self._reset = function()
	{
		$('#exportCsvSectionsAll').prop('checked', true);
		$('#exportCsvSectionsSelection').html('');

		var $hint = $('#exportCsvSeparatorHintContainer');
		self.format === 'excel' ? $hint.show() : $hint.hide();
	}
}

;

