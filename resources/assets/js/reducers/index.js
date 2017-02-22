import { combineReducers } from 'redux';
import { itemCategories, selectedItemCategory, categoryMenuDrawerOpen } from './inventoryReducer';
import { loading } from './loadingReducer';

const rootReducer = combineReducers({
	itemCategories,
	selectedItemCategory,
	categoryMenuDrawerOpen,
	loading,
});

export default rootReducer;
