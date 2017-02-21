import React, { Component, PropTypes } from 'react';
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';

const ItemRow = ({item}) => (
	<TableRow hoverable>
		<TableRowColumn>{item.id}</TableRowColumn>
		<TableRowColumn>{item.quantity}</TableRowColumn>
        <TableRowColumn>{item.serial_number}</TableRowColumn>
        <TableRowColumn>{item.category}</TableRowColumn>	
        <TableRowColumn>{item.size}</TableRowColumn>	
        <TableRowColumn>{item.color}</TableRowColumn>	
        <TableRowColumn>{item.description}</TableRowColumn>	
    </TableRow>
);

class InventoryTable extends Component {
	render() {
		return (
			<Table>
		    	<TableHeader displaySelectAll={false} adjustForCheckbox={false}>
					<TableRow>
						<TableHeaderColumn>ID</TableHeaderColumn>
						<TableHeaderColumn>QTY</TableHeaderColumn>
						<TableHeaderColumn>Serial #</TableHeaderColumn>
						<TableHeaderColumn>Category</TableHeaderColumn>
						<TableHeaderColumn>Size</TableHeaderColumn>
						<TableHeaderColumn>Color</TableHeaderColumn>
						<TableHeaderColumn>Description</TableHeaderColumn>
					</TableRow>
				</TableHeader>
				<TableBody displayRowCheckbox={false} showRowHover preScanRows={false}>
					{this.props.items && this.props.items.map((item) => (
						<ItemRow key={item.id} item={item} />
					))}
				</TableBody>
		    </Table>
		)
	};
}

InventoryTable.PropTypes = {
	items: PropTypes.array,
};

export default InventoryTable;