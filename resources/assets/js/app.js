require('./bootstrap');
import React from 'react';
import { createStore, applyMiddleware } from 'redux';
import { fromJS, Map, List } from 'immutable';
import thunkMiddleware from 'redux-thunk';
import ReactDOM from 'react-dom';
import injectTapEventPlugin from 'react-tap-event-plugin';
import Perf from 'react-addons-perf';
import mountInventory from './mountInventory';
import CategoryItemsTable from './containers/CategoryItemsTable';
import rootReducer from './reducers';
import { fetchItems } from './actions/inventoryActions';

// Needed for onTouchTap (Material-UI)
// http://stackoverflow.com/a/34015469/988941
injectTapEventPlugin();

// React perf addon - for debugging performance issues
window.Perf = Perf;

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const initialState = fromJS({});

const store = createStore(
	rootReducer,
	initialState,
	composeEnhancers(
		applyMiddleware(
		    thunkMiddleware, // lets us dispatch() functions
		)
	)
);

store.dispatch(fetchItems());

if(document.getElementById('inventory')) {
	mountInventory(store);
}
