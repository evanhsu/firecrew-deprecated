import React, { PropTypes, Component } from 'react';
import { connect } from 'react-redux';
import AccountableItemTable from '../components/AccountableItemTable';
import BulkItemTable from '../components/BulkItemTable';
import BulkIssuedItemTable from '../components/BulkIssuedItemTable';

class CategoryItemsTable extends Component {
	render() {
		return (
			<div>
				<h1>{ this.props.category }</h1>
				<AccountableItemTable items={this.props.accountableItems} /> 
				<BulkItemTable items={this.props.bulkItems} /> 
				<BulkIssuedItemTable items={this.props.bulkIssuedItems} />
			</div>
		);
	}
}

CategoryItemsTable.propTypes = {
	category: PropTypes.string,
	items: PropTypes.arrayOf(PropTypes.object),
}

CategoryItemsTable.defaultProps = {
	category: null,
	items: [],
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
	};
}

export default connect(mapStateToProps)(CategoryItemsTable);

