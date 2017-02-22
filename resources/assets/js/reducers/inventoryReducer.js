import { 
	SELECT_ITEM_CATEGORY,
	TOGGLE_CATEGORY_MENU_DRAWER,
	SET_CATEGORY_MENU_DRAWER_STATE,
	REQUEST_ITEM_CATEGORY,
	RECEIVE_ITEM_CATEGORY,
	INVALIDATE_ITEM_CATEGORY,
	REQUEST_ITEM_CATEGORIES,
	RECEIVE_ITEM_CATEGORIES,
	INVALIDATE_ITEM_CATEGORIES,
	EXPAND_TABLE_ROW,
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
			console.log('Update all categories');
			return Object.assign({}, state, 
				action.categories
			);
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
			return !state.categoryMenuDrawerOpen;
		case SET_CATEGORY_MENU_DRAWER_STATE:
			return action.open;
		default:
			return state;
	}
}

export function expandedRowKeys(state = [], action) {
	switch(action.type) {
		case EXPAND_TABLE_ROW:
			return action.rows;
		default:
			return state;
	}
}