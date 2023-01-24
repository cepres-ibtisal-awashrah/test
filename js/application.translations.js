/*******************************************************************/
/* Translations  */

App.Translations = new function()
{
	var self = this;
	self.translations = [];

	self.add = function(key, translation)
	{
		self.translations[key] = translation;
	}

	self.get = function(key)
	{
		return self.translations[key] || '';
	}
}

function lang(key)
{
	return App.Translations.get(key);
}

function langc(key)
{
	if (key.indexOf('l:') === 0)
	{
		return lang(key.substring(2));
	}
	else 
	{
		return key;
	}
}

;

