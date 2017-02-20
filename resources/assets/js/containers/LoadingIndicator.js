import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import RefreshIndicator from 'material-ui/RefreshIndicator';

class LoadingIndicator extends Component {
	render() {
		return (
			<RefreshIndicator left={100} top={100} size={300} status={this.props.loading ? 'loading' : 'hide'} />
		);
	};
}

LoadingIndicator.propTypes = {
	loading: PropTypes.bool,
}

LoadingIndicator.defaultProps = {
	loading: {false},
}

function mapStateToProps(state) {
	return {
		loading: state.loading,
	};
}

export default connect(mapStateToProps)(LoadingIndicator);
