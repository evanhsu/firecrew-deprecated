import React, { Component } from 'react';
import { Route, Switch } from 'react-router-dom';
import StatusSummary from './containers/StatusSummary';
import Inventory from './containers/Inventory';

class Routes extends Component {
	render() {
		return (
			<Switch>
				<Route path="/crew/:crewId/inventory" component={Inventory} />
				<Route path="/" exact component={StatusSummary} />
			</Switch>
		);
	}
};

export default Routes;
