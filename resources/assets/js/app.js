import React from 'react';
import ReactDOM from 'react-dom';
import { createStore, applyMiddleware, compose } from 'redux';
import { Provider } from 'react-redux';
import thunkMiddleware from 'redux-thunk';
import { ConnectedRouter, routerMiddleware } from 'react-router-redux';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js'; // eslint-disable-line no-unused-vars
import createHistory from 'history/createBrowserHistory';
import { fromJS } from 'immutable';
import injectTapEventPlugin from 'react-tap-event-plugin';
import Perf from 'react-addons-perf';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import rootReducer from './reducers';
import Inventory from './containers/Inventory';
import StatusSummary from './containers/StatusSummary';
import Routes from './routes.js';

require('./bootstrap');


// Needed for onTouchTap (Material-UI)
// http://stackoverflow.com/a/34015469/988941
injectTapEventPlugin();

// React perf addon - for debugging performance issues
window.Perf = Perf;

// Create a browser history for use with React Router
const history = createHistory();

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose; // eslint-disable-line no-underscore-dangle
const initialState = fromJS({});

const store = createStore(
  rootReducer,
  initialState,
  composeEnhancers(
    applyMiddleware(
      thunkMiddleware, // lets us dispatch() functions
      routerMiddleware(history)
    )
  )
);

// Set up Laravel Echo to connect to a Pusher account
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: window.Laravel.pusher.appKey, // TODO: key: process.env.MIX_PUSHER_KEY (requires Mix v2.0)
  cluster: window.Laravel.pusher.cluster,
  encrypted: window.Laravel.pusher.encrypted,
});

if (document.getElementById('react-root')) {
  ReactDOM.render(
    <Provider store={store}>
      <ConnectedRouter history={history}>
        <MuiThemeProvider>
          <Routes />
        </MuiThemeProvider>
      </ConnectedRouter>
    </Provider>,
    document.getElementById('react-root')
  );
}

