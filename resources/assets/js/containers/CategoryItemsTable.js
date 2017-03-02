import React, { PropTypes, Component } from 'react';
import { connect } from 'react-redux';
import { List } from 'immutable';
import AccountableItemTable from '../components/AccountableItemTable';
import BulkItemTable from '../components/BulkItemTable';
import BulkIssuedItemTable from '../components/BulkIssuedItemTable';
import { itemRowSelected, itemRowDeselected, incrementItem, decrementItem } from '../actions/inventoryActions';

class CategoryItemsTable extends Component {
	handleDecrement = (itemId) => {
		(event) => {
			event.preventDefault();
			return () => this.props.dispatch(decrementItem(this.props.category, itemId));
		};
	};

	handleIncrement = (itemId) => {
		(event) => {
			event.preventDefault();
			return () => this.props.dispatch(incrementItem(this.props.category, itemId));
		};
	};

	handleRowClick = (itemId) => {
		event.preventDefault(); 
		if(itemId === this.props.selectedItemRow) {
			return this.props.dispatch(itemRowDeselected(itemId))
		} else {
			return this.props.dispatch(itemRowSelected(itemId));
		}
	};

	itemRowFormOpen = () => {
		return this.props.selectedItemRow === null ? false : true;
	};

	render() {
		return (
			<div>
				<h1>{ this.props.category }</h1>
				<AccountableItemTable 
					items={this.props.accountableItems}
					onRowClick={this.handleRowClick}
					selectedItemRow={this.props.selectedItemRow}
				/>
				<BulkItemTable 
					items={this.props.bulkItems} 
					onRowClick={this.handleRowClick} 
					handleIncrement={this.handleIncrement}
					handleDecrement={this.handleDecrement}
					selectedItemRow={this.props.selectedItemRow}
				/> 
				<BulkIssuedItemTable 
					items={this.props.bulkIssuedItems}
					onRowClick={this.handleRowClick}
					selectedItemRow={this.props.selectedItemRow}
				/>
			</div>
		);
	}
}

CategoryItemsTable.propTypes = {
	accountableItems: PropTypes.object,
	bulkItems: PropTypes.object,
	bulkIssuedItems: PropTypes.object,
	category: PropTypes.string,
	selectedItemRow: PropTypes.number,
	itemRowFormContents: PropTypes.any,
}

CategoryItemsTable.defaultProps = {
	category: null,
	accountableItems: List(),
	bulkItems: List(),
	bulkIssuedItems: List(),
	selectedItemRow: null,
}

function mapStateToProps(state) {
	const categoryName = state.get('selectedItemCategory');
	const accountableItems = (items) => {
		return items.filter((item) => {
			return ((item.type == 'accountable') && (item.category == categoryName));
		});
	}
	const bulkItems = (items) => {
		return items.filter((item) => (item.type == 'bulk' && item.parentId === null && item.category == categoryName));
	}
	const bulkIssuedItems = (items) => {
		return items.filter((item) => (item.type == 'bulk' && item.parentd !== null && item.category == categoryName));
	}
	return {
		category: categoryName,
		accountableItems: accountableItems(state.getIn(['items', 'data'])),
		bulkItems: bulkItems(state.getIn(['items', 'data'])),
		bulkIssuedItems: bulkIssuedItems(state.getIn(['items', 'data'])),
		selectedItemRow: state.get('selectedItemRow'),
	};
}

export default connect(mapStateToProps)(CategoryItemsTable);

