import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import Menu from 'material-ui/Menu';
import MenuItem from 'material-ui/MenuItem';

class CategoryMenu extends Component {

	renderRows = () => {
		return this.props.categories.map((category) => {
			return (<MenuItem key={category} primaryText={category} />);
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
	return {
		categories: Object.keys(state.itemCategories).map((category) => {
			return category;
		}),
	};
}

export default connect(mapStateToProps)(CategoryMenu);
