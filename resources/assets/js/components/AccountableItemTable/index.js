import React, { PureComponent, PropTypes } from 'react';
import ImmutableProptypes from 'react-immutable-proptypes';
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
				<span style={mdColStyle}>Serial #</span>
				<span style={lgColStyle}>Description</span>
				<span style={smColStyle}>Size</span>
				<span style={smColStyle}>Color</span>
				<span style={mdColStyle}>Issued To</span>
				<span style={smColStyle}>Usable</span>
				<span style={mdColStyle}>Condition</span>
				<span style={lgColStyle}>Note</span>
				<span style={lgColStyle}>Updated</span>
			</div>
	);
};

const ItemRow = ({itemId, item, onTouchTap, selectedItemRow}) => {
	return (
        <ListItem key={`item-${itemId}`} style={rowStyle} open={selectedItemRow === itemId} onTouchTap={()=>onTouchTap(itemId)}
        	nestedItems={[
        		<ListItem key={`expanded-item-${itemId}`} disabled style={rowStyle}>
					<span style={mdColStyle}><TextField floatingLabelText="Serial #" inputStyle={mdTextFieldStyle} name={`item-${itemId}-serial_number`} defaultValue={item.get('serial_number')} /></span>
			        <span style={lgColStyle}><TextField floatingLabelText="Description" inputStyle={lgTextFieldStyle} name={`item-${itemId}-description`} defaultValue={item.get('description')} /></span>	
			        <span style={smColStyle}><TextField floatingLabelText="Size" inputStyle={smTextFieldStyle} name={`item-${itemId}-item_size`} defaultValue={item.get('item_size')} /></span>	
			        <span style={smColStyle}><TextField floatingLabelText="Color" inputStyle={smTextFieldStyle} name={`item-${itemId}-color`} defaultValue={item.get('color')} /></span>	
					<span style={mdColStyle}><TextField floatingLabelText="Issued To" inputStyle={mdTextFieldStyle} name={`item-${itemId}-checked_out_to`} defaultValue={item.get('checked_out_to')} /></span>
			        <span style={smColStyle}><TextField floatingLabelText="Usable" inputStyle={smTextFieldStyle} name={`item-${itemId}-usable`} defaultValue={item.get('usable')} /></span>	
			        <span style={mdColStyle}><TextField floatingLabelText="Condition" inputStyle={mdTextFieldStyle} name={`item-${itemId}-condition`} defaultValue={item.get('condition')} /></span>	
			        <span style={lgColStyle}><TextField floatingLabelText="Note" inputStyle={lgTextFieldStyle} name={`item-${itemId}-note`} defaultValue={item.get('note')} /></span>	
			        <span style={lgColStyle}></span>
        		</ListItem> 
    		]}
		>
        	<span style={mdColStyle}>{item.get('serial_number')}</span>
	        <span style={lgColStyle}>{item.get('description')}</span>	
	        <span style={smColStyle}>{item.get('item_size')}</span>	
	        <span style={smColStyle}>{item.get('color')}</span>	
			<span style={mdColStyle}>{item.get('checked_out_to') && item.getIn(['checked_outTo', 'full_name'])}</span>
	        <span style={smColStyle}>{item.get('usable')}</span>	
	        <span style={mdColStyle}>{item.get('condition')}</span>	
	        <span style={lgColStyle}>{item.get('note')}</span>	
	        <span style={lgColStyle}>{moment(item.get('updated_at')).format('YYYY-MM-DD')}</span>
		</ListItem>
    );
}

class AccountableItemTable extends PureComponent {
	render() {
		if(this.props.items.size == 0) {
			return null;
		} else {
			return (
				<div>
			    	<HeaderRow />
			    	<List>
					{this.props.items.map((item) => (
						
						<ItemRow 
							key={item.get('id')} 
							itemId={item.get('id')}
							item={item.get('attributes')} 
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

AccountableItemTable.PropTypes = {
	items: ImmutableProptypes.list,
	onRowClick: PropTypes.func,
	selectedItemRow: PropTypes.number,
};

export default AccountableItemTable;

