require('./bootstrap');
import React from 'react';
import { createStore } from 'redux'
import ReactDOM from 'react-dom';
import injectTapEventPlugin from 'react-tap-event-plugin';
import mountInventory from './mountInventory';
import CategoryItemsTable from './containers/CategoryItemsTable';
import rootReducer from './reducers'

// Needed for onTouchTap (Material-UI)
// http://stackoverflow.com/a/34015469/988941
injectTapEventPlugin();

const initialState = {
	itemCategories: [],
	selectedItemCategory: null
};

const fireCrewStore = createStore(rootReducer, initialState);

if(document.getElementById('inventory')) {
	mountInventory(fireCrewStore);
}
