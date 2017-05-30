require('./bootstrap');
import React from 'react';
import ReactDOM from 'react-dom';
import { createStore, applyMiddleware, compose } from 'redux';
import { Provider } from 'react-redux';
import thunkMiddleware from 'redux-thunk';
import { Route } from 'react-router-dom';
import { ConnectedRouter, routerMiddleware } from 'react-router-redux';
import createHistory from 'history/createBrowserHistory';
import { fromJS } from 'immutable';
import injectTapEventPlugin from 'react-tap-event-plugin';
import Perf from 'react-addons-perf';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import rootReducer from './reducers';
import App from './containers/App';
import { fetchItems } from './containers/CategoryItemsTable/actions';


// Needed for onTouchTap (Material-UI)
// http://stackoverflow.com/a/34015469/988941
injectTapEventPlugin();

// React perf addon - for debugging performance issues
window.Perf = Perf;

// Create a browser history for use with React Router
const history = createHistory();

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const initialState = fromJS({});

const store = createStore(
        rootReducer,
        initialState,
        composeEnhancers(
                applyMiddleware(
                        thunkMiddleware, // lets us dispatch() functions
                        routerMiddleware(history),
                )
        )
);

store.dispatch(fetchItems()); // TODO: Move this to CategoryItemsTable.componentWillUpdate?

if (document.getElementById('inventory')) {
    ReactDOM.render(
            <Provider store={store}>
                <ConnectedRouter history={history}>
                    <MuiThemeProvider>
                        <Route path="/crew/:crewId/inventory" component={App}/>
                    </MuiThemeProvider>
                </ConnectedRouter>
            </Provider>,
            document.getElementById('inventory')
    )
}
