import React, { Component, PropTypes } from 'react';
import ImmutablePropTypes from 'react-immutable-proptypes';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { List } from 'immutable';
import Menu from 'material-ui/Menu';
import MenuItem from 'material-ui/MenuItem';
import { selectItemCategory } from '../../actions/inventoryActions';

class CategoryMenu extends Component {

	handleClick = (category) => () => this.props.selectItemCategory(category);
		
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
	categories: ImmutablePropTypes.list,
}

CategoryMenu.defaultProps = {
	categories: List(),
}

function mapStateToProps(state) {
	return {
		categories: state.getIn(['categories', 'data']),
	};
}

function mapDispatchToProps(dispatch) {
	return {
		selectItemCategory: (category) => dispatch(selectItemCategory(category)),
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(CategoryMenu);
