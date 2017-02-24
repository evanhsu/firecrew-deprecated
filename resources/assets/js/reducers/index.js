import { combineReducers } from 'redux';
import { 
	itemCategories,
	selectedItemCategory,
	categoryMenuDrawerOpen,
	selectedItemRow,
	itemRowFormContents,
	} from './inventoryReducer';
import { loading } from './loadingReducer';

const rootReducer = combineReducers({
	itemCategories,
	selectedItemCategory,
	categoryMenuDrawerOpen,
	loading,
	selectedItemRow,
	itemRowFormContents,
});

export default rootReducer;
