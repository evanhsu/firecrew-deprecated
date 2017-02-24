import React, { PropTypes } from 'react';
import { Popover } from 'material-ui/Popover';
import { Card, CardActions, CardHeader, CardText } from 'material-ui/Card';
import { TextField } from 'material-ui/TextField';

const ItemRowPopover = (props) => {
	const item = props.children && props.children.props.item;
	console.log(props.children);
	return (
		<Popover
          open={props.open}
          anchorEl={props.anchorEl}
          anchorOrigin={{horizontal: 'left', vertical: 'bottom'}}
          targetOrigin={{horizontal: 'left', vertical: 'top'}}
          onRequestClose={props.onRequestClose}
        >
        	{props.children}
        </Popover>
	);
};

ItemRowPopover.propTypes = {
	anchorEl: PropTypes.object,
	children: PropTypes.any,
	open: PropTypes.bool, 
	onRequestClose: PropTypes.func,
};

export default ItemRowPopover;
