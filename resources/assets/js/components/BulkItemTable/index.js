import React, { Component, PropTypes } from 'react';
import { Card, CardActions, CardHeader, CardText } from 'material-ui/Card';
import TextField from 'material-ui/TextField';
import { IncrementButton, DecrementButton } from '../QuantityButtons';

const cellStyle = {
	paddingLeft: 5,
	paddingRight: 5,
	minHeight: 20,
	display: 'inline-block',
	overflowWrap: 'break-word',
	textOverflow: 'ellipsis',
};

const rowStyle = {
	minHeight: 20,
	padding: 0,
};

const headerRowStyle = {
	fontSize: 16,
	fontWeight: 600,
	minHeight: 20,
	padding: 0,
};

const formContainerStyle = {
	backgroundColor: "#fafafa",
	border: '3px solid #2eb2fd',
	boxShadow: '3px 3px 8px #888888',
	padding: 0,
};

const textFieldStyle = {
	fontSize: 14,
	paddingRight: 5,
};

const xsColWidth = { width: 35 };
const smColWidth = { width: 70 };
const mdColWidth = { width: 120 };
const lgColWidth = { width: 180 };

const xsColStyle = Object.assign({}, cellStyle, xsColWidth);
const smColStyle = Object.assign({}, cellStyle, smColWidth);
const mdColStyle = Object.assign({}, cellStyle, mdColWidth);
const lgColStyle = Object.assign({}, cellStyle, lgColWidth);

const xsTextFieldStyle = Object.assign({}, textFieldStyle, smColWidth);
const smTextFieldStyle = Object.assign({}, textFieldStyle, smColWidth);
const mdTextFieldStyle = Object.assign({}, textFieldStyle, mdColWidth);
const lgTextFieldStyle = Object.assign({}, textFieldStyle, lgColWidth);

const HeaderRow = () => {
	return (
		<Card expandable={false}>
			<CardText color="#888888" style={headerRowStyle}>
				<span style={mdColStyle}>Qty</span>
				<span style={lgColStyle}>Description</span>
				<span style={smColStyle}>Size</span>
				<span style={smColStyle}>Color</span>
				<span style={mdColStyle}>Min Qty</span>
				<span style={mdColStyle}>Restock</span>
				<span style={lgColStyle}>Note</span>
				<span style={lgColStyle}>Source</span>
				<span style={lgColStyle}>Updated</span>
			</CardText>
		</Card>
	);
};

const ItemRow = ({item, onTouchTap, onExpandChange, handleIncrement, handleDecrement}) => {
	return (
		<Card style={rowStyle} onExpandChange={onExpandChange}>
	        <CardText style={rowStyle} actAsExpander onTouchTap={(event) => onTouchTap(event)}>
	        	<span style={mdColStyle}>{item.quantity}</span>
		        <span style={lgColStyle}>{item.description}</span>	
		        <span style={smColStyle}>{item.size}</span>	
		        <span style={smColStyle}>{item.color}</span>	
				<span style={mdColStyle}>{item.restock_trigger}</span>
		        <span style={mdColStyle}>{item.restock_to_quantity}</span>	
		        <span style={lgColStyle}>{item.note}</span>	
		        <span style={lgColStyle}>{item.source}</span>	
		        <span style={lgColStyle}>{item.updated_at}</span>
			</CardText>
			<CardText expandable style={formContainerStyle}>
	        	<span style={xsColStyle}><DecrementButton onTouchTap={handleDecrement(item.id)} /></span>
		    	<span style={smColStyle}><TextField floatingLabelText="Quantity" 	inputStyle={xsTextFieldStyle} name={`item-${item.id}-quantity`} 		defaultValue={item.quantity} /></span>
	        	<span style={xsColStyle}><IncrementButton onTouchTap={handleIncrement(item.id)} /></span>
		        <span style={lgColStyle}><TextField floatingLabelText="Description" inputStyle={lgTextFieldStyle} name={`item-${item.id}-description`} 		defaultValue={item.description} /></span>	
		        <span style={smColStyle}><TextField floatingLabelText="Size" 		inputStyle={smTextFieldStyle} name={`item-${item.id}-size`} 			defaultValue={item.size} /></span>	
		        <span style={smColStyle}><TextField floatingLabelText="Color" 		inputStyle={smTextFieldStyle} name={`item-${item.id}-color`} 			defaultValue={item.color} /></span>	
				<span style={mdColStyle}><TextField floatingLabelText="Min Qty" 	inputStyle={mdTextFieldStyle} name={`item-${item.id}-restock-trigger`} 	defaultValue={item.restock_trigger} /></span>
		        <span style={mdColStyle}><TextField floatingLabelText="Restock" 	inputStyle={mdTextFieldStyle} name={`item-${item.id}-restock-to-quantity`} defaultValue={item.restock_to_quantity} /></span>	
		        <span style={lgColStyle}><TextField floatingLabelText="Note" 		inputStyle={lgTextFieldStyle} name={`item-${item.id}-note`} 			defaultValue={item.note} /></span>	
		        <span style={lgColStyle}><TextField floatingLabelText="Source" 		inputStyle={lgTextFieldStyle} name={`item-${item.id}-source`} 			defaultValue={item.source} /></span>	
		        <span style={lgColStyle}></span>
		    </CardText>
	    </Card>
    );
}

// const RowForm = ({item}) => {
// 	return (
//         <Card style={rowStyle}>
// 			<CardText style={formContainerStyle}>
// 		    	<span style={mdColStyle}><TextField floatingLabelText="Serial #" inputStyle={mdTextFieldStyle} name={`item-${item.id}-serial-number`} defaultValue={item.serial_number} /></span>
// 		        <span style={lgColStyle}><TextField floatingLabelText="Description" inputStyle={lgTextFieldStyle} name={`item-${item.id}-description`} defaultValue={item.description} /></span>	
// 		        <span style={smColStyle}><TextField floatingLabelText="Size" inputStyle={smTextFieldStyle} name={`item-${item.id}-size`} defaultValue={item.size} /></span>	
// 		        <span style={smColStyle}><TextField floatingLabelText="Color" inputStyle={smTextFieldStyle} name={`item-${item.id}-color`} defaultValue={item.color} /></span>	
// 				<span style={mdColStyle}><TextField floatingLabelText="Issued To" inputStyle={mdTextFieldStyle} name={`item-${item.id}-checked_out_to`} defaultValue={item.checked_out_to} /></span>
// 		        <span style={smColStyle}><TextField floatingLabelText="Usable" inputStyle={smTextFieldStyle} name={`item-${item.id}-usable`} defaultValue={item.usable} /></span>	
// 		        <span style={mdColStyle}><TextField floatingLabelText="Condition" inputStyle={mdTextFieldStyle} name={`item-${item.id}-condition`} defaultValue={item.condition} /></span>	
// 		        <span style={lgColStyle}><TextField floatingLabelText="Note" inputStyle={lgTextFieldStyle} name={`item-${item.id}-note`} defaultValue={item.note} /></span>	
// 		        <span style={lgColStyle}></span>
// 		    </CardText>
//         </Card>
// 	);
// };

class BulkItemTable extends Component {
	render() {
		if(this.props.items.length == 0) {
			return null;
		} else {
			const items = this.props.items.toArray(); // Convert from Immutable List to js Array
			return (
				<div>
			    	<HeaderRow />
					{this.props.items && items.map((item) => (
						<ItemRow 
							key={item.id} 
							item={item} 
							onTouchTap={this.props.onRowClick} 
							onExpandChange={this.props.onRowRequestClose} 
							handleIncrement={this.props.handleIncrement}
							handleDecrement={this.props.handleDecrement}
						/>
					))}
			    </div>
			);
		}
	};
}

BulkItemTable.PropTypes = {
	handleIncrement: PropTypes.func,
	handleDecrement: PropTypes.func,
	items: PropTypes.array,
	onRowClick: PropTypes.func,
	onRowRequestClose: PropTypes.func,
};

export default BulkItemTable;
