import React, { PropTypes, Component } from 'react';
import { connect } from 'react-redux';
import AccountableItemTable from '../components/AccountableItemTable';
import BulkItemTable from '../components/BulkItemTable';
import BulkIssuedItemTable from '../components/BulkIssuedItemTable';
import ItemRowPopover from '../components/ItemRowPopover';
import { itemRowSelected, itemRowDeselected } from '../actions/inventoryActions';

class CategoryItemsTable extends Component {
	handleRowClick = (event, form) => {
		event.preventDefault();
		return this.props.dispatch(itemRowSelected(event.currentTarget, form));
	};

	handleRowFormRequestClose = () => {
		return this.props.dispatch(itemRowDeselected());
	};

	itemRowFormOpen = () => {
		return this.props.selectedItemRow === null ? false : true;
	};

	render() {
		// return (
		// 	<div>
		// 		<h1>{ this.props.category }</h1>
		// 		<AccountableItemTable items={this.props.accountableItems} onRowClick={this.handleRowClick} />
		// 		<BulkItemTable items={this.props.bulkItems} /> 
		// 		<BulkIssuedItemTable items={this.props.bulkIssuedItems} />

		// 		<ItemRowPopover 
		// 			anchorEl={this.props.selectedItemRow}
		// 			open={this.itemRowFormOpen()}
		// 			onRequestClose={this.handleRowFormRequestClose}
		// 		>
		// 			{this.props.itemRowFormContents}
		// 		 </ItemRowPopover> */
		// 	</div>
		// );
		return (
			<div>
				<h1>{ this.props.category }</h1>
				<AccountableItemTable items={this.props.accountableItems} onRowClick={this.handleRowClick} />
				<BulkItemTable items={this.props.bulkItems} /> 
				<BulkIssuedItemTable items={this.props.bulkIssuedItems} />
			</div>
		);
	}
}

CategoryItemsTable.propTypes = {
	accountableItems: PropTypes.arrayOf(PropTypes.object),
	bulkItems: PropTypes.arrayOf(PropTypes.object),
	bulkIssuedItems: PropTypes.arrayOf(PropTypes.object),
	category: PropTypes.string,
	selectedItemRow: PropTypes.object,
	itemRowFormContents: PropTypes.any,
}

CategoryItemsTable.defaultProps = {
	category: null,
	accountableItems: [],
	bulkItems: [],
	bulkIssuedItems: [],
	selectedItemRow: null,
}

function mapStateToProps(state) {
	const categoryName = state.selectedItemCategory;
	const accountableItems = (items) => {
		return items.filter((item) => (item.type == 'accountable'));
	}
	const bulkItems = (items) => {
		return items.filter((item) => (item.type == 'bulk' && item.parent_id === null));
	}
	const bulkIssuedItems = (items) => {
		return items.filter((item) => (item.type == 'bulk' && item.parent_id !== null));
	}
	return {
		category: categoryName,
		accountableItems: state.itemCategories[categoryName] ? accountableItems(state.itemCategories[categoryName].items) : [],
		bulkItems: state.itemCategories[categoryName] ? bulkItems(state.itemCategories[categoryName].items) : [],
		bulkIssuedItems: state.itemCategories[categoryName] ? bulkIssuedItems(state.itemCategories[categoryName].items) : [],
		selectedItemRow: state.selectedItemRow,
		itemRowFormContents: state.itemRowFormContents,
	};
}

export default connect(mapStateToProps)(CategoryItemsTable);

