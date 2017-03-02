import React, { PureComponent, PropTypes } from 'react';
import TextField from 'material-ui/TextField';
import { List, ListItem } from 'material-ui/List';
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
		<div color="#888888" style={headerRowStyle}>
			<span style={mdColStyle}>Qty</span>
			<span style={lgColStyle}>Description</span>
			<span style={smColStyle}>Size</span>
			<span style={smColStyle}>Color</span>
			<span style={mdColStyle}>Min Qty</span>
			<span style={mdColStyle}>Restock</span>
			<span style={lgColStyle}>Note</span>
			<span style={lgColStyle}>Source</span>
			<span style={lgColStyle}>Updated</span>
		</div>
	);
};

const ItemRow = ({item, onTouchTap, selectedItemRow, handleIncrement, handleDecrement}) => {
	return (
		<ListItem 
			key={`item-${item.id}`} 
			style={rowStyle} 
			open={selectedItemRow === item.id} 
			onTouchTap={()=>onTouchTap(item.id)}
	        nestedItems={[
        		<ListItem key={`expanded-item-${item.id}`} disabled style={rowStyle}>
        			<span style={xsColStyle}><DecrementButton onTouchTap={handleDecrement(item.id)} /></span>
			    	<span style={smColStyle}><TextField floatingLabelText="Quantity" 	inputStyle={xsTextFieldStyle} name={`item-${item.id}-quantity`} 		defaultValue={item.quantity} /></span>
			    	<span style={xsColStyle}><IncrementButton onTouchTap={handleIncrement(item.id)} /></span>
			        <span style={lgColStyle}><TextField floatingLabelText="Description" inputStyle={lgTextFieldStyle} name={`item-${item.id}-description`} 		defaultValue={item.description} /></span>	
			        <span style={smColStyle}><TextField floatingLabelText="Size" 		inputStyle={smTextFieldStyle} name={`item-${item.id}-item-size`} 		defaultValue={item.itemSize} /></span>	
			        <span style={smColStyle}><TextField floatingLabelText="Color" 		inputStyle={smTextFieldStyle} name={`item-${item.id}-color`} 			defaultValue={item.color} /></span>	
					<span style={mdColStyle}><TextField floatingLabelText="Min Qty" 	inputStyle={mdTextFieldStyle} name={`item-${item.id}-restock-trigger`} 	defaultValue={item.restockTrigger} /></span>
			        <span style={mdColStyle}><TextField floatingLabelText="Restock" 	inputStyle={mdTextFieldStyle} name={`item-${item.id}-restock-to-quantity`} defaultValue={item.restockToQuantity} /></span>	
			        <span style={lgColStyle}><TextField floatingLabelText="Note" 		inputStyle={lgTextFieldStyle} name={`item-${item.id}-note`} 			defaultValue={item.note} /></span>	
			        <span style={lgColStyle}><TextField floatingLabelText="Source" 		inputStyle={lgTextFieldStyle} name={`item-${item.id}-source`} 			defaultValue={item.source} /></span>	
			        <span style={lgColStyle}></span>
				</ListItem>
			]}
		>
	    	
        	<span style={mdColStyle}>{item.quantity}</span>
	        <span style={lgColStyle}>{item.description}</span>	
	        <span style={smColStyle}>{item.itemSize}</span>	
	        <span style={smColStyle}>{item.color}</span>	
			<span style={mdColStyle}>{item.restock_trigger}</span>
	        <span style={mdColStyle}>{item.restock_to_quantity}</span>	
	        <span style={lgColStyle}>{item.note}</span>	
	        <span style={lgColStyle}>{item.source}</span>	
	        <span style={lgColStyle}>{moment(item.updatedAt).format('YYYY-MM-DD')}</span>
	    </ListItem>
    );
}

class BulkItemTable extends PureComponent {
	render() {
		if(this.props.items.size == 0) {
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
							handleIncrement={this.props.handleIncrement}
							handleDecrement={this.props.handleDecrement}
							selectedItemRow={this.props.selectedItemRow}
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
	selectedItemRow: PropTypes.number,
};

export default BulkItemTable;
