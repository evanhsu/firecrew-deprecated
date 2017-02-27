import React, { PropTypes, Component } from 'react';
import { connect } from 'react-redux';
import AccountableItemTable from '../components/AccountableItemTable';
import BulkItemTable from '../components/BulkItemTable';
import BulkIssuedItemTable from '../components/BulkIssuedItemTable';
import ItemRowPopover from '../components/ItemRowPopover';
import { itemRowSelected, itemRowDeselected, incrementItem, decrementItem } from '../actions/inventoryActions';

class CategoryItemsTable extends Component {
	handleDecrement = (itemId) => {
		return () => this.props.dispatch(decrementItem(this.props.category, itemId));
	};

	handleIncrement = (itemId) => {
		return () => this.props.dispatch(incrementItem(this.props.category, itemId));
	};

	handleRowClick = (event) => {
		// event.preventDefault(); 
		return this.props.dispatch(itemRowSelected(event.currentTarget));
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
				<AccountableItemTable items={this.props.accountableItems} onRowClick={this.handleRowClick} onRowRequestClose={this.handleRowFormRequestClose} />
				<BulkItemTable 
					items={this.props.bulkItems} 
					onRowClick={this.handleRowClick} 
					onRowRequestClose={this.handleRowFormRequestClose} 
					handleIncrement={this.handleIncrement}
					handleDecrement={this.handleDecrement}
				/> 
				<BulkIssuedItemTable items={this.props.bulkIssuedItems} onRowClick={this.handleRowClick} onRowRequestClose={this.handleRowFormRequestClose} />
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
		accountableItems: accountableItems(state.get('items')),
		bulkItems: bulkItems(state.get('items')),
		bulkIssuedItems: bulkIssuedItems(state.get('items')),
		selectedItemRow: state.selectedItemRow,
	};
}

export default connect(mapStateToProps)(CategoryItemsTable);

