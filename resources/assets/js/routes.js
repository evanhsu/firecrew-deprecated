import React, { Component } from 'react';
import { Route, Switch } from 'react-router-dom';
import Inventory from './containers/Inventory';
import StatusMap from './containers/StatusMap';
import StatusSummary from './containers/StatusSummary';

class Routes extends Component {
  render() {
    return (
      <Switch>
        <Route path="/crew/:crewId/inventory" component={Inventory} />
        <Route path="/summary" exact component={StatusSummary} />
        <Route path="/map" exact component={StatusMap} />
        <Route path="/" exact component={StatusSummary} />
      </Switch>
    );
  }
}

export default Routes;
