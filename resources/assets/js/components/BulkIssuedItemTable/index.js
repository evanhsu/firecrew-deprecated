import React, { PureComponent, PropTypes } from 'react';
import TextField from 'material-ui/TextField';
import { List, ListItem } from 'material-ui/List';
import moment from 'moment';

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

const smColWidth = { width: 70 };
const mdColWidth = { width: 120 };
const lgColWidth = { width: 180 };

const smColStyle = Object.assign({}, cellStyle, smColWidth);
const mdColStyle = Object.assign({}, cellStyle, mdColWidth);
const lgColStyle = Object.assign({}, cellStyle, lgColWidth);

const smTextFieldStyle = Object.assign({}, textFieldStyle, smColWidth);
const mdTextFieldStyle = Object.assign({}, textFieldStyle, mdColWidth);
const lgTextFieldStyle = Object.assign({}, textFieldStyle, lgColWidth);

const HeaderRow = () => {
	return (
		<div color="#888888" style={headerRowStyle}>
			<span style={mdColStyle}>Qty</span>
			<span style={lgColStyle}>Description</span>
			<span style={lgColStyle}>Issued To</span>
			<span style={mdColStyle}>Size</span>
			<span style={mdColStyle}>Color</span>
			<span style={lgColStyle}>Updated</span>
		</div>
	);
};

const ItemRow = ({item, onTouchTap, selectedItemRow}) => {
	return (
		<ListItem 
			key={`item-${item.id}`} 
			style={rowStyle} 
			open={selectedItemRow === item.id} 
			onTouchTap={()=>onTouchTap(item.id)}
	        nestedItems={[
        		<ListItem key={`expanded-item-${item.id}`} disabled style={rowStyle}>
		        	<span style={mdColStyle}><TextField floatingLabelText="Quantity" 	inputStyle={mdTextFieldStyle} name={`item-${item.id}-quantity`} 		defaultValue={item.quantity} /></span>
			        <span style={lgColStyle}><TextField floatingLabelText="Description" inputStyle={lgTextFieldStyle} name={`item-${item.id}-description`} 		defaultValue={item.description} /></span>	
			        <span style={lgColStyle}><TextField floatingLabelText="Issued To" 	inputStyle={lgTextFieldStyle} name={`item-${item.id}-checked_out_to`} 	defaultValue={item.checkedOutTo && item.checkedOutTo.get('full_name')} /></span>	
			        <span style={mdColStyle}><TextField floatingLabelText="Size" 		inputStyle={mdTextFieldStyle} name={`item-${item.id}-item-size`} 		defaultValue={item.itemSize} /></span>	
			        <span style={mdColStyle}><TextField floatingLabelText="Color" 		inputStyle={mdTextFieldStyle} name={`item-${item.id}-color`} 			defaultValue={item.color} /></span>	
			        <span style={lgColStyle}></span>
			    </ListItem>
				]}
    		>
    		<span style={mdColStyle}>{item.quantity}</span>
	        <span style={lgColStyle}>{item.description}</span>	
	        <span style={lgColStyle}>{item.checkedOutTo && item.checkedOutTo.get('full_name')}</span>	
	        <span style={mdColStyle}>{item.itemSize}</span>	
	        <span style={mdColStyle}>{item.color}</span>	
	        <span style={lgColStyle}>{moment(item.updatedAt).format('YYYY-MM-DD')}</span>
		</ListItem>
	    	
    );
}

class BulkIssuedItemTable extends PureComponent {
	render() {
		if(this.props.items.size == 0) {
			return null;
		} else {
			const items = this.props.items.toArray(); // Convert from Immutable List to js Array
			return (
				<div>
			    	<HeaderRow />
			    	<List>
					{this.props.items && items.map((item) => (
						<ItemRow 
							key={item.id} 
							item={item} 
							onTouchTap={this.props.onRowClick} 
							selectedItemRow={this.props.selectedItemRow}
						/>
					))}
					</List>
			    </div>
			);
		}
	};
}

BulkIssuedItemTable.PropTypes = {
	items: PropTypes.array,
	onRowClick: PropTypes.func,
	selectedItemRow: PropTypes.number,
};

export default BulkIssuedItemTable;

