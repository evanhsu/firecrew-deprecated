import React, { Component, PropTypes } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { List } from 'immutable';
import Menu from 'material-ui/Menu';
import MenuItem from 'material-ui/MenuItem';
import { selectItemCategory } from '../actions/inventoryActions';

class CategoryMenu extends Component {

	handleClick = (category) => {
		return () => {
			this.props.dispatch(selectItemCategory(category));
		}
	}
		
	renderRows = () => {
		return this.props.categories.map((category) => {
			return (<MenuItem key={category} primaryText={category} onTouchTap={this.handleClick(category)} />);
		});
	};

	render() {
		return (
			<Menu>
				{ this.renderRows() }
			</Menu>
		);
	}
}

CategoryMenu.propTypes = {
	categories: PropTypes.object,
}

CategoryMenu.defaultProps = {
	categories: List(),
}

const categoryListFromItems = (items) => {
	return items
			.map((item) => item.category)
			.toSet()
			.toList()
			.sort();
};

function mapStateToProps(state) {
	return {
		categories: categoryListFromItems(state.getIn(['items', 'data'])),
	};
}

export default connect(mapStateToProps)(CategoryMenu);
