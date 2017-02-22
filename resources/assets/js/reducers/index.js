import { combineReducers } from 'redux';
import { itemCategories, selectedItemCategory, categoryMenuDrawerOpen, expandedRowKeys } from './inventoryReducer';
import { loading } from './loadingReducer';

const rootReducer = combineReducers({
	itemCategories,
	selectedItemCategory,
	categoryMenuDrawerOpen,
	expandedRowKeys,
	loading,
});

export default rootReducer;
