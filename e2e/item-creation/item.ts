import type { Locator, Page } from "@playwright/test";

import { fillText, testEntity, testTitle } from "./common";

/**
 *
 * @param page
 */
async function createItem(page: Page) {
    const name = await fillText(page, "Item");
    return { name };
}

/**
 *
 * @param page
 * @param result
 * @param result.name
 */
async function checkResult(page: Page, result: { name: string }) {
    const { name } = result;
    await testTitle(page, "item", name);
}

/**
 *
 * @param page
 * @param generated
 * @param generated.name
 * @param _page
 * @param _generated
 * @param _generated.name
 * @param locator
 */
async function editItem(
    _page: Page,
    _generated: { name: string },
    locator: Locator,
) {
    const name = await fillText(locator, "Item");

    return { name };
}

/**
 *
 * @param page
 */
export async function testItem(page: Page) {
    return await testEntity(
        page,
        "Items",
        "item",
        (_page) => createItem(page),
        checkResult,
        editItem,
    );
}
