import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import injectTapEventPlugin from 'react-tap-event-plugin';
import Inventory from './containers/Inventory';

export default function mountInventory(reduxStore) {
	ReactDOM.render(
		<Provider store={reduxStore}>
			<MuiThemeProvider>
				<Inventory />
			</MuiThemeProvider>
		</Provider>,
		document.getElementById('inventory')
	)
}
