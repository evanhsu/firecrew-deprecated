import { combineReducers } from 'redux';
import { itemCategories, selectedItemCategory } from './inventoryReducer';
import { loading } from './loadingReducer';

const rootReducer = combineReducers({
	itemCategories,
	selectedItemCategory,
	loading,
});

export default rootReducer;
