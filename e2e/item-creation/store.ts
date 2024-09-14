import type { Locator, Page } from "@playwright/test";

import { fillText, testEntity, testTitle } from "./common";

/**
 *
 * @param page
 */
async function createStore(page: Page) {
    const name = await fillText(page, "Store");
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
    await testTitle(page, "store", name);
}

/**
 *
 * @param page
 * @param generated
 * @param generated.name
 * @param locator
 */
async function editStore(
    _page: Page,
    _generated: { name: string },
    locator: Locator,
) {
    const name = await fillText(locator, "Store");

    return { name };
}

/**
 *
 * @param page
 */
export async function testStore(page: Page) {
    return await testEntity(
        page,
        "Stores",
        "store",
        (_page) => createStore(page),
        checkResult,
        editStore,
    );
}
