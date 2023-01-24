/**********************************************************************************************/
/* Drag + Drop  */

/* [Permissions checked!] */

App.DragDrop =  new function()
{
	var self = this;

	self.dragging = false;

	self.isDragging = function()
	{
		return self.dragging;
	}

	self.stop = function()
	{
		self.dragging = false;
		$('body').removeClass('dragging');
	}

	self.start = function()
	{
		$('body').addClass('dragging');
		self.dragging = true;
	}
}

;

