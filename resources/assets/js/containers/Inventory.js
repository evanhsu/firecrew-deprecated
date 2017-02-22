import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import CategoryMenu from './CategoryMenu';
import CategoryItemsTable from './CategoryItemsTable';
import LoadingIndicator from './LoadingIndicator';
import Drawer from 'material-ui/Drawer';
import RaisedButton from 'material-ui/RaisedButton';
import { setCategoryMenuDrawerState } from '../actions/inventoryActions';

class Inventory extends Component {

	setDrawerState = (open) => {
		return () => this.props.dispatch(setCategoryMenuDrawerState(open));
	}

	render() {
		return (
			<div className="col-xs-12">
				<div className="drawer-toggle-button">
					<RaisedButton label='Categories' primary onTouchTap={this.setDrawerState(true)} />
				</div>
				<div className="panel panel-primary">
					<div className="panel-heading">
						<h1 className="panel-title">Inventory</h1>
					</div> 
					<div className="panel-body">
						<Drawer
				          docked={false}
				          width={350}
				          open={this.props.categoryMenuDrawerOpen}
				          onRequestChange={this.setDrawerState(false)}
				        >
				        	<CategoryMenu />
				        </Drawer>
				        <CategoryItemsTable />
						<LoadingIndicator />
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
		categoryMenuDrawerOpen: state.categoryMenuDrawerOpen
	};
}

export default connect(mapStateToProps)(Inventory);
