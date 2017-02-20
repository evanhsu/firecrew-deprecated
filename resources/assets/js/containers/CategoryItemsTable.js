import React, { PropTypes, Component } from 'react';
import { connect } from 'react-redux';
import InventoryTable from '../components/InventoryTable';

class CategoryItemsTable extends Component {
	render() {
		return (
			<div>
				<h1>{ this.props.category }</h1>
				<InventoryTable items={this.props.items} />
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
	return {
		category: categoryName,
		items: state.itemCategories ? state.itemCategories[categoryName].items : [],
	};
}

export default connect(mapStateToProps)(CategoryItemsTable);

