import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import injectTapEventPlugin from 'react-tap-event-plugin';
import CategoryItemsTable from './containers/CategoryItemsTable';
import CategoryMenu from './containers/CategoryMenu';
import LoadingIndicator from './containers/LoadingIndicator';

export default function mountInventory(reduxStore) {
	ReactDOM.render(
		<Provider store={reduxStore}>
			<MuiThemeProvider>
				<CategoryItemsTable />
			</MuiThemeProvider>
		</Provider>,
		document.getElementById('items-table')
	)

	ReactDOM.render(
		<Provider store={reduxStore}>
			<MuiThemeProvider>
				<CategoryMenu />
			</MuiThemeProvider>
		</Provider>,
		document.getElementById('category-menu')
	)

	ReactDOM.render(
		<Provider store={reduxStore}>
			<MuiThemeProvider>
				<LoadingIndicator />
			</MuiThemeProvider>
		</Provider>,
		document.getElementById('loading-indicator')
	)
}
