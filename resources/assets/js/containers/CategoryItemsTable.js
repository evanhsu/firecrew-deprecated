import React, { PropTypes, Component } from 'react';
import { connect } from 'react-redux';
import { List } from 'immutable';
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
				<AccountableItemTable 
					items={this.props.accountableItems}
					onRowClick={this.handleRowClick}
					onRowRequestClose={this.handleRowFormRequestClose}
				/>
				<BulkItemTable 
					items={this.props.bulkItems} 
					onRowClick={this.handleRowClick} 
					onRowRequestClose={this.handleRowFormRequestClose} 
					handleIncrement={this.handleIncrement}
					handleDecrement={this.handleDecrement}
				/> 
				<BulkIssuedItemTable 
					items={this.props.bulkIssuedItems}
					onRowClick={this.handleRowClick}
					onRowRequestClose={this.handleRowFormRequestClose}
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
	selectedItemRow: PropTypes.object,
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
		selectedItemRow: state.selectedItemRow,
	};
}

export default connect(mapStateToProps)(CategoryItemsTable);

