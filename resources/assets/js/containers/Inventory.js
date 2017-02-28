import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import ReactDrawer from 'react-drawer';
import CategoryMenu from './CategoryMenu';
import CategoryItemsTable from './CategoryItemsTable';
import LoadingIndicator from './LoadingIndicator';
import Drawer from 'material-ui/Drawer';
import RaisedButton from 'material-ui/RaisedButton';
import { toggleCategoryMenuDrawer } from '../actions/inventoryActions';
 
class Inventory extends Component {

	toggleDrawerState = () => (
		this.props.dispatch(toggleCategoryMenuDrawer())
	); 

	render() {
		return (
			<div className="col-xs-12">
				<div className="drawer-toggle-button">
					<RaisedButton label='Categories' primary onClick={this.toggleDrawerState} />
				</div>
				<div className="panel panel-primary">
					<div className="panel-heading">
						<h1 className="panel-title">Inventory</h1>
						<LoadingIndicator />
					</div> 
					<div className="panel-body">
						<Drawer
				          docked={false}
				          width={350}
				          open={this.props.categoryMenuDrawerOpen}
				          onRequestChange={this.toggleDrawerState}
				        >
				        	<CategoryMenu />
				        </Drawer>
				        <CategoryItemsTable />
					</div>
				</div>
			</div>
		);
	};
}

Inventory.propTypes = {
	categoryMenuDrawerOpen: PropTypes.bool,
}

function mapStateToProps(state) {
	return {
		categoryMenuDrawerOpen: state.get('categoryMenuDrawerOpen'),
	};
}

export default connect(mapStateToProps)(Inventory);
