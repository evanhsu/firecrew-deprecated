import { combineReducers } from 'redux-immutable';

import { categoryMenuDrawerOpen, selectedItemCategory } from './navigationReducer';
import { items } from './itemsReducer';
import { categories } from './categoriesReducer';
import { selectedItemRow } from './selectedItemRowReducer';
import { reducer as formReducer } from 'redux-form/immutable';

 const rootReducer = combineReducers({
	categories: categories,
	categoryMenuDrawerOpen: categoryMenuDrawerOpen,
    form: formReducer,
	items: items,
	selectedItemCategory: selectedItemCategory,
	selectedItemRow: selectedItemRow,
});

export default rootReducer;
