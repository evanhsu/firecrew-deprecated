import { combineReducers } from 'redux-immutable';

import { categoryMenuDrawerOpen, selectedItemCategory } from './navigationReducer';
import { items } from './itemsReducer';

const rootReducer = combineReducers({
	categoryMenuDrawerOpen: categoryMenuDrawerOpen,
	items: items,
	selectedItemCategory: selectedItemCategory,
});

export default rootReducer;
