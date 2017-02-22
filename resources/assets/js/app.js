require('./bootstrap');
import React from 'react';
import { createStore, applyMiddleware } from 'redux';
import thunkMiddleware from 'redux-thunk';
import ReactDOM from 'react-dom';
import injectTapEventPlugin from 'react-tap-event-plugin';
import Perf from 'react-addons-perf';

import mountInventory from './mountInventory';
import CategoryItemsTable from './containers/CategoryItemsTable';
import rootReducer from './reducers';
import { fetchItemCategories } from './actions/inventoryActions';

// Needed for onTouchTap (Material-UI)
// http://stackoverflow.com/a/34015469/988941
injectTapEventPlugin();

// React perf addon - for debugging performance issues
window.Perf = Perf;

const store = createStore(
	rootReducer,
	window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__(),
	applyMiddleware(
	    thunkMiddleware, // lets us dispatch() functions
	)
);

store.dispatch(fetchItemCategories());

if(document.getElementById('inventory')) {
	mountInventory(store);
}
