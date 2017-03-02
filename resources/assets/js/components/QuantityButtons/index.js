import React, { PropTypes } from 'react';
import IconButton from 'material-ui/IconButton';
import AddCircle from 'material-ui/svg-icons/content/add-circle';
import RemoveCircle from 'material-ui/svg-icons/content/remove-circle';

const buttonColor = "#bfbfbf";
const style = { padding: 5, width: 30 };

const IncrementButton = (props) => {
	return (
		<IconButton 
			tooltip="Increase Quantity by 1"
			onTouchTap={props.onTouchTap}
			style={style}
		>
			<AddCircle color={buttonColor} />
		</IconButton>
	); 
}

IncrementButton.propTypes = {
	onTouchTap: PropTypes.func,
};

const DecrementButton = (props) => {
	return (
		<IconButton 
			tooltip="Decrease Quantity by 1"
			onTouchTap={props.onTouchTap}
			style={style}
		>
			<RemoveCircle color={buttonColor} />
		</IconButton>
	); 
}

DecrementButton.propTypes = {
	onTouchTap: PropTypes.func,
};

export { IncrementButton, DecrementButton };
