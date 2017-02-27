import React, { Component, PropTypes } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { Iterable, Map, List } from 'immutable';
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
	categories: PropTypes.arrayOf(PropTypes.string),
}

CategoryMenu.defaultProps = {
	categories: [],
}

function mapStateToProps(state) {
	// console.log(state.get('items'));
	return {
		categories: [],//state.get('items').keys().map((category) => category),
	};
}

export default connect(mapStateToProps)(CategoryMenu);
