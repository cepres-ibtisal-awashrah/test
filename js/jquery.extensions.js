
jQuery.fn.extend(
{
	insertAtCaret: function(value)
	{
		return this.each(function()
		{
			if (this.selectionStart)
			{
				var start = this.selectionStart,
					end = this.selectionEnd,
					scrollTop = this.scrollTop;

				this.value = this.value.substring(0, start) + value +
					this.value.substring(end, this.value.length);

				this.focus();
				this.selectionStart = start + value.length;
				this.selectionEnd = start + value.length;
				this.scrollTop = scrollTop;
			}
			else
			{
				this.value += value;
				this.focus();
			}
		});
	},

	divInsertAtCaret: function(value, range)
	{
		var sel = window.getSelection();

		return this.each(function()
		{
			range.deleteContents();

			var el = document.createElement('div');
			el.innerHTML = value;
			var frag = document.createDocumentFragment(), node, lastNode;
			while (node = el.firstChild) {
				lastNode = frag.appendChild(node);
			}
			range.insertNode(frag);

			// Preserve the selection
			if (lastNode) {
				range = range.cloneRange();
				range.setStartAfter(lastNode);
				range.collapse(true);
				sel.removeAllRanges();
				sel.addRange(range);
			}
		});
	},

	eachDivInsertAtCaret: function(existRange, nodes, status) {
		this.each(function() {
			let id = this.getAttribute('id');
			let index = '#' + id;

			for (let node of nodes) {
				if (index.match('_display') || this.getAttribute('contenteditable')) {
					let _range = document.createRange();

					if (!existRange) {
						let parent = document.getElementById(id);

						if (parent?.lastChild) {
							_range.setStartAfter(parent?.lastChild);
						} else {
							_range.setStart(parent, 0);
						}
					} else {
						_range = existRange.cloneRange();
					}

					let range = document.createRange();

					if ('#' + _range.startContainer.id === index) {
						if (_range.startContainer.childNodes.length) {
							if (_range.startContainer.lastChild.textContent === '\n') {
								range.setStart(_range.startContainer.lastChild, _range.startContainer.lastChild.textContent.length);
								range.setEnd(_range.startContainer.lastChild, _range.startContainer.lastChild.textContent.length);
							} else {
								range.setStartBefore(_range.startContainer.lastChild);
							}
						} else {
							range.setStart(_range.startContainer, 0);
						}
					} else {
						if (_range.startContainer.nodeName === '#text') {
							if (_range.startContainer.textContent.length === _range.startOffset) {
								range.setStartAfter(_range.startContainer);
							} else {
								range.setStart(_range.startContainer, _range.startOffset);
								range.setEnd(_range.startContainer, _range.startOffset);
							}
						} else {
							range.setStartAfter(_range.startContainer);
						}
					}

					let selection = window.getSelection();

					if (node[0]) {
						range.insertNode(node[0]);
						range.collapse(false);
						selection.removeAllRanges();
						selection.addRange(range);
					}

					range.setStart(node[0], node[0].length);
					range.setEnd(node[0], node[0].length);
					range.collapse(false);
					selection.removeAllRanges();
					selection.addRange(range);
					existRange = range.cloneRange();

					if (!status.imagePasted && !status.imageDraged) {
						App.Editor.setHistory(index, document.getElementById(id).childNodes, node[0]);
					}
				}
			}
		});

		return existRange.cloneRange();
	}
});

;

