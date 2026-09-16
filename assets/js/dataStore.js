/**
 * Hospital Management System (HMS) - Data Store Layer
 * Handles client-side persistence in localStorage and notifies components on updates.
 */

const HMSDataStore = (function () {
  const STORAGE_KEY = 'MEDPULSE_HMS_DATA_V1';

  function init() {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (!stored || !stored.includes('H1268')) {
      resetToDefault();
    } else if (stored.includes('photo-1594824813580-c116c478e58a')) {
      const fixed = stored.replace(/photo-1594824813580-c116c478e58a/g, 'photo-1622902046580-2b47f47f5471');
      localStorage.setItem(STORAGE_KEY, fixed);
    }
  }

  function getAllData() {
    try {
      const data = localStorage.getItem(STORAGE_KEY);
      if (data) {
        return JSON.parse(data);
      }
    } catch (e) {
      console.error('Error reading HMS data store:', e);
    }
    return resetToDefault();
  }

  function saveAllData(data) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
      window.dispatchEvent(new CustomEvent('hms:data-changed', { detail: { timestamp: Date.now() } }));
    } catch (e) {
      console.error('Error saving HMS data store:', e);
    }
  }

  function resetToDefault() {
    const defaultData = typeof INITIAL_DUMMY_DATA !== 'undefined' ? JSON.parse(JSON.stringify(INITIAL_DUMMY_DATA)) : {};
    localStorage.setItem(STORAGE_KEY, JSON.stringify(defaultData));
    window.dispatchEvent(new CustomEvent('hms:data-changed', { detail: { action: 'reset' } }));
    return defaultData;
  }

  function getCollection(collectionName) {
    const data = getAllData();
    return Array.isArray(data[collectionName]) ? data[collectionName] : [];
  }

  function saveCollection(collectionName, items) {
    const data = getAllData();
    data[collectionName] = items;
    saveAllData(data);
  }

  function addItem(collectionName, item) {
    const items = getCollection(collectionName);
    items.unshift(item); // insert at top
    saveCollection(collectionName, items);
    return item;
  }

  function updateItem(collectionName, idKey, idValue, updatedFields) {
    const items = getCollection(collectionName);
    const index = items.findIndex(item => String(item[idKey]) === String(idValue));
    if (index !== -1) {
      items[index] = { ...items[index], ...updatedFields };
      saveCollection(collectionName, items);
      return items[index];
    }
    return null;
  }

  function deleteItem(collectionName, idKey, idValue) {
    let items = getCollection(collectionName);
    const initialLen = items.length;
    items = items.filter(item => String(item[idKey]) !== String(idValue));
    if (items.length !== initialLen) {
      saveCollection(collectionName, items);
      return true;
    }
    return false;
  }

  function findItem(collectionName, idKey, idValue) {
    const items = getCollection(collectionName);
    return items.find(item => String(item[idKey]) === String(idValue)) || null;
  }

  // Initialize store on load
  init();

  return {
    getCollection,
    saveCollection,
    addItem,
    updateItem,
    deleteItem,
    findItem,
    resetToDefault,
    getAllData
  };
})();

if (typeof window !== 'undefined') {
  window.HMSDataStore = HMSDataStore;
}
