import type { Locator, Page } from "@playwright/test";
import { fillText, testEntity, testTitle } from "./common";

/**
 * Creates a test store.
 * @param page The Playwright page.
 * @returns The generated store name.
 */
async function createStore(page: Page) {
    const name = await fillText(page, "Store");
    return { name };
}

/**
 * Checks that the store was created.
 * @param page The Playwright page.
 * @param result The generated store.
 * @param result.name The store name.
 */
async function checkResult(page: Page, result: { name: string }) {
    const { name } = result;
    await testTitle(page, "store", name);
}

/**
 * Attempts to edit a store.
 * @param _page The Playwright page.
 * @param _generated The generated store.
 * @param _generated.name The store name.
 * @param locator The locator.
 * @returns The updated store.
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
 * Tests the store creation, editing, and deletion.
 * @param page The Playwright page.
 * @returns The generated store.
 */
export async function testStore(page: Page): Promise<{ name: string }> {
    return await testEntity(
        page,
        "Stores",
        "store",
        (_page) => createStore(page),
        checkResult,
        editStore,
    );
}
