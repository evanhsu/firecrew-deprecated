import React, { PropTypes, Component } from 'react';
import ImmutablePropTypes from 'react-immutable-proptypes';
import { connect } from 'react-redux';
import AccountableItemTable from '../../components/AccountableItemTable';
import BulkItemTable from '../../components/BulkItemTable';
import BulkIssuedItemTable from '../../components/BulkIssuedItemTable';
import * as Actions from './actions';
import selectCategoryItemsTable from './selectors';

class CategoryItemsTable extends Component {
    static propTypes = {
        category: PropTypes.string,
        accountableItems: ImmutablePropTypes.map,
        bulkItems: ImmutablePropTypes.map,
        bulkIssuedItems: ImmutablePropTypes.map,
        selectedItemRow: PropTypes.number,
        loading: PropTypes.bool,
        itemRowFormContents: PropTypes.any,
        incrementItem: PropTypes.func,
        decrementItem: PropTypes.func,
        itemRowSelected: PropTypes.func,
        itemRowDeselected: PropTypes.func,
    };

    static defaultProps = {
        category: null,
        accountableItems: null,
        bulkItems: null,
        bulkIssuedItems: null,
        activeItemRow: null,
    };

    handleDecrement = (itemId) => {
        return () => {
            event.preventDefault();
            return this.props.decrementItem(itemId);
        };
    };

    handleIncrement = (itemId) => {
        return () => {
            event.preventDefault();
            return this.props.incrementItem(itemId);
        }
    };

    handleRowClick = (itemId) => {
        event.preventDefault();
        itemId = parseInt(itemId, 10);
        if (itemId === this.props.selectedItemRow) {
            return this.props.itemRowDeselected(itemId)
        } else {
            return this.props.itemRowSelected(itemId);
        }
    };

    itemRowFormOpen = () => {
        return this.props.activeItemRow !== null;
    };

    render() {
        return (
                <div>
                    <h1>{ this.props.category }</h1>
                    <AccountableItemTable
                            items={this.props.accountableItems}
                            onRowClick={this.handleRowClick}
                            selectedItemRow={this.props.selectedItemRow}
                    />
                    <BulkItemTable
                            items={this.props.bulkItems}
                            onRowClick={this.handleRowClick}
                            handleIncrement={this.handleIncrement}
                            handleDecrement={this.handleDecrement}
                            selectedItemRow={this.props.selectedItemRow}
                    />
                    <BulkIssuedItemTable
                            items={this.props.bulkIssuedItems}
                            onRowClick={this.handleRowClick}
                            selectedItemRow={this.props.selectedItemRow}
                    />
                </div>
        );
    }
}

const mapStateToProps = selectCategoryItemsTable();

function mapDispatchToProps(dispatch) {
    return {
        itemRowSelected: (itemId) => dispatch(Actions.itemRowSelected(itemId)),
        itemRowDeselected: (itemId) => dispatch(Actions.itemRowDeselected(itemId)),
        incrementItem: (itemId) => dispatch(Actions.incrementItem(itemId)),
        decrementItem: (itemId) => dispatch(Actions.decrementItem(itemId)),
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(CategoryItemsTable);

