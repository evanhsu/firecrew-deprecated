import { 
	SELECT_ITEM_CATEGORY,
	TOGGLE_CATEGORY_MENU_DRAWER,
	REQUEST_ITEM_CATEGORY,
	RECEIVE_ITEM_CATEGORY,
	INVALIDATE_ITEM_CATEGORY,
	REQUEST_ITEM_CATEGORIES,
	RECEIVE_ITEM_CATEGORIES,
	INVALIDATE_ITEM_CATEGORIES,
	ITEM_ROW_SELECTED,
	ITEM_ROW_DESELECTED,	
} from '../actions/inventoryActions';

function category(state = { isFetching: false, didInvalidate: false, items: [] }, action) {
	switch(action.type) {
		case RECEIVE_ITEM_CATEGORY:
			return Object.assign({}, state, {
				items: action.items,
				isFetching: false,
				didInvalidate: false,
				lastUpdated: action.receivedAt,
			});
		case REQUEST_ITEM_CATEGORY:
			return Object.assign({}, state, {
				isFetching: true,
				didInvalidate: false,
			});
		case INVALIDATE_ITEM_CATEGORY:
			return Object.assign({}, state, {
				didInvalidate: true,
			});
		default:
			return state;
	}
}

export function itemCategories(state = {}, action) {
	switch(action.type) {
		case RECEIVE_ITEM_CATEGORY:
			return Object.assign({}, state, {
				[action.categoryName]: category(state[action.categoryName], action)
			});
		case RECEIVE_ITEM_CATEGORIES:
			return action.categories; // REPLACE the entire state.itemCategories

		default:
			return state;
	}
}

export function selectedItemCategory(state = '', action) {
	switch(action.type) {
		case SELECT_ITEM_CATEGORY:
			return action.categoryName;
		default:
			return state;
	}
}

export function categoryMenuDrawerOpen(state = false, action) {
	switch(action.type) {
		case TOGGLE_CATEGORY_MENU_DRAWER:
			return !state;
		case SELECT_ITEM_CATEGORY:
			return false;
		default:
			return state;
	}
}

export function selectedItemRow(state = null, action) {
	switch(action.type) {
		case ITEM_ROW_SELECTED:
			return action.row;
		case ITEM_ROW_DESELECTED:
			return null;
		default:
			return state;
	}
}

export function itemRowFormContents(state = null, action) {
	switch(action.type) {
		case ITEM_ROW_SELECTED:
			return action.form;
		case ITEM_ROW_DESELECTED:
			return null;
		default:
			return state;
	}
}