import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn } from 'material-ui/Table';
import { expandTableRow } from '../actions/inventoryActions';


const cellStyle = {
	padding: 5,
	height: 30,
	whiteSpace: 'normal',
};

const rowStyle = {
	height: 30,
};

const smColWidth = { width: 50 };
const mdColWidth = { width: 100 };
const lgColWidth = { width: 165 };

const smColStyle = Object.assign({}, cellStyle, smColWidth);
const mdColStyle = Object.assign({}, cellStyle, mdColWidth);
const lgColStyle = Object.assign({}, cellStyle, lgColWidth);

class AccountableCollapsibleTable extends Component {

    handleRowClick(rowId) {
        const currentExpandedRows = this.props.expandedRowKeys;
        const isRowCurrentlyExpanded = currentExpandedRows.includes(rowId);
        
        const newExpandedRows = isRowCurrentlyExpanded ? 
			currentExpandedRows.filter(id => id !== rowId) : 
			currentExpandedRows.concat(rowId);
        
        this.props.dispatch(expandTableRow(newExpandedRows));
    }

    renderItem(item) {
        const clickCallback = () => this.handleRowClick(item.id);
        const itemRows = [
			<TableRow style={rowStyle} hoverable selectable={false} onClick={clickCallback} key={"row-data-" + item.id}>
				<TableRowColumn style={smColStyle}>{item.serial_number}</TableRowColumn>
			    <TableRowColumn style={lgColStyle}>{item.description}</TableRowColumn>	
		        <TableRowColumn style={smColStyle}>{item.size}</TableRowColumn>	
		        <TableRowColumn style={smColStyle}>{item.color}</TableRowColumn>	
				<TableRowColumn style={mdColStyle}>{item.checked_out_to && item.checked_out_to.full_name}</TableRowColumn>
		        <TableRowColumn style={smColStyle}>{item.usable}</TableRowColumn>	
		        <TableRowColumn style={smColStyle}>{item.condition}</TableRowColumn>	
		        <TableRowColumn style={lgColStyle}>{item.note}</TableRowColumn>	
		        <TableRowColumn style={mdColStyle}>{item.updated_at}</TableRowColumn>	
			</TableRow>
        ];
        
        if(this.props.expandedRowKeys.includes(item.id)) {
            itemRows.push(
            	<TableRow style={rowStyle} hoverable selectable={false} key={"row-expanded-" + item.id}>
                    <TableRowColumn style={smColStyle}><input type='text' defaultValue={item.serial_number} /></TableRowColumn>
				    <TableRowColumn style={lgColStyle}><input type='text' defaultValue={item.description} /></TableRowColumn>	
			        <TableRowColumn style={smColStyle}><input type='text' defaultValue={item.size} /></TableRowColumn>	
			        <TableRowColumn style={smColStyle}><input type='text' defaultValue={item.color} /></TableRowColumn>	
					<TableRowColumn style={mdColStyle}>&nbsp;</TableRowColumn>
			        <TableRowColumn style={smColStyle}><input type='text' defaultValue={item.usable} /></TableRowColumn>	
			        <TableRowColumn style={smColStyle}><input type='text' defaultValue={item.condition} /></TableRowColumn>	
			        <TableRowColumn style={lgColStyle}><input type='text' defaultValue={item.note} /></TableRowColumn>	
			        <TableRowColumn style={mdColStyle}>&nbsp;</TableRowColumn>
                </TableRow>
            );
        }
        
        return itemRows;    
    }

	render() {
		if(this.props.items.length == 0) {
			return null;
		} else {
			let allItemRows = [];
        
	        this.props.items.forEach(item => {
	            const perItemRows = this.renderItem(item);
	            allItemRows = allItemRows.concat(perItemRows);
	        });
	        
	        return (
			    <Table>
			    	<TableHeader displaySelectAll={false} adjustForCheckbox={false}>
						<TableRow>
							<TableHeaderColumn style={smColStyle}>Serial #</TableHeaderColumn>
							<TableHeaderColumn style={lgColStyle}>Description</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Size</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Color</TableHeaderColumn>
							<TableHeaderColumn style={mdColStyle}>Issued To</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Usable</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Condition</TableHeaderColumn>
							<TableHeaderColumn style={lgColStyle}>Note</TableHeaderColumn>
							<TableHeaderColumn style={mdColStyle}>Updated</TableHeaderColumn>
						</TableRow>
					</TableHeader>
				    <TableBody displayRowCheckbox={false} showRowHover preScanRows={false}>
			    		{allItemRows}
			    	</TableBody>
			    </Table>
	        );
		}
	};
}

AccountableCollapsibleTable.PropTypes = {
	items: PropTypes.array,
	expandedRowKeys: PropTypes.array,
};

function mapStateToProps(state) {
	const categoryName = state.selectedItemCategory;
	const accountableItems = (items) => {
		return items.filter((item) => (item.type == 'accountable'));
	}
	return {
		expandedRowKeys: state.expandedRowKeys,
		accountableItems: state.itemCategories[categoryName] ? accountableItems(state.itemCategories[categoryName].items) : [],
	}
}

export default connect(mapStateToProps)(AccountableCollapsibleTable);
