import React, { PropTypes, Component } from 'react';
import { connect } from 'react-redux';
import { List } from 'immutable';
import AccountableItemTable from '../../components/AccountableItemTable';
import BulkItemTable from '../../components/BulkItemTable';
import BulkIssuedItemTable from '../../components/BulkIssuedItemTable';
import { itemRowSelected, itemRowDeselected, incrementItem, decrementItem } from '../../actions/inventoryActions';

class CategoryItemsTable extends Component {
	handleDecrement = (itemId) => {
		return () => {
			event.preventDefault();
			return this.props.dispatch(decrementItem(itemId));
		};
	};

	handleIncrement = (itemId) => {
		return () => {
			event.preventDefault();
			return this.props.dispatch(incrementItem(itemId));
		}
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

const accountableItems = (categoryName) => (item) => (
	(item.getIn(['attributes', 'type']) === 'accountable') 
	&& (item.getIn(['attributes', 'category']) === categoryName)
);

const bulkItems = (categoryName) => (item) => (
	(item.getIn(['attributes', 'type']) === 'bulk') 
	&& (item.getIn(['attributes', 'parentId']) === null) 
	&& (item.getIn(['attributes', 'category']) === categoryName)
);

const bulkIssuedItems = (categoryName) => (item) => (
	(item.getIn(['attributes', 'type']) === 'bulk') 
	&& (item.getIn(['attributes', 'parentId']) !== null) 
	&& (item.getIn(['attributes', 'category']) === categoryName)
);

function mapStateToProps(state) {
	const categoryName = state.getIn(['selectedItemCategory']);
	const items = state.getIn(['items', 'data']);
	return {
		category: categoryName,
		accountableItems: items.filter(accountableItems(categoryName)),
		bulkItems: items.filter(bulkItems(categoryName)),
		bulkIssuedItems: items.filter(bulkIssuedItems(categoryName)),
		selectedItemRow: state.get('selectedItemRow'),
	};
}

export default connect(mapStateToProps)(CategoryItemsTable);

