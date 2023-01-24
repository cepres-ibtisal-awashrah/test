/*******************************************************************/
/* Storage related routines (e.g. get/set keys) */

/* [Permissions checked!] */

App.Storage = new function()
{
	var self = this;

	self.keys = [];

	self.init = function()
	{
		self.keys = self._getKeys();
	}

	self._getKeys = function()
	{
		var keys = self._get('testrail:storage.keys');
		return keys ? JSON.parse(keys) : [];
	}

	self._setKeys = function(keys)
	{
		var value = JSON.stringify(keys);
		return self._trySet('testrail:storage.keys', value);
	}

	self._trySet = function(key, value)
	{
		try
		{
			localStorage.setItem(key, value);
		}
		catch (error)
		{
			return false;
		}

		return true;
	}

	self._set = function(key, value)
	{
		if (!localStorage)
		{
			return;
		}

		// localStorage doesn't have native support for a FIFO queue
		// and we manage the queue ourselves. We do this by tracking
		// the list of keys in localStorage and removing the oldest
		// key(s) in case adding a new key fails.

		var exists = self._exists(key);

		while (!self._trySet(key, value))
		{
			if (!self._tryRemoveOldest())
			{
				break;
			}
		}

		if (!exists)
		{
			self.keys.push(key);
		}

		// And synchronize the key store (queue) as the last step.
		// This may fail as well if there's not enough room left and
		// we try to remove the oldest values in a loop as before.

		while (!self._setKeys(self.keys))
		{
			if (!self._tryRemoveOldest())
			{
				// Synchronizing the key ultimately failed and we need
				// to clean things up.
				localStorage.clear();
				self.keys = [];
				break;
			}
		}
	}

	self._tryRemoveOldest = function()
	{
		if (self.keys.length == 0)
		{
			return false; // No keys to remove (queue is empty)
		}

		try
		{
			var k = self.keys.shift();
			localStorage.removeItem(k);
		}
		catch (error)
		{
			return false;
		}

		return true;
	}

	self._exists = function(key)
	{
		return self._get(key) !== null;
	}

	self._get = function(key)
	{
		if (!localStorage)
		{
			return null;
		}

		try 
		{
			return localStorage.getItem(key) || null;
		}
		catch (error)
		{
			return null;
		}
	}

	self._formatObjectKey = function(ns, id)
	{
		// For example: testrail:suites.groups.expand:1 (for suite with
		// the ID 1).
		return 'testrail:' + ns + ':' + id;
	}

	self.setObject = function(ns, id, obj)
	{
		var key = self._formatObjectKey(ns, id);
		self._set(key, JSON.stringify(obj));
	}

	self.setObjectItem = function(ns, id, key, value)
	{
		var obj = self.getObject(ns, id) || {};
		obj[key] = value;
		self.setObject(ns, id, obj); 
	}

	self.getObject = function(ns, id)
	{
		var key = self._formatObjectKey(ns, id);
		var str = self._get(key);
		return str ? JSON.parse(str) : null;
	}
}

;

