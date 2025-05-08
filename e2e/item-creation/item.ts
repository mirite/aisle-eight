import type { Locator, Page } from "@playwright/test";
import { fillText, testEntity, testTitle } from "./common";

/**
 * Creates an item.
 * @param page The Playwright page.
 * @returns The generated item.
 */
async function createItem(page: Page): Promise<{ name: string }> {
    const name = await fillText(page, "Item");
    return { name };
}

/**
 * Verifies the item was created.
 * @param page The Playwright page.
 * @param result The generated item.
 * @param result.name The item name.
 */
async function checkResult(page: Page, result: { name: string }) {
    const { name } = result;
    await testTitle(page, "item", name);
}

/**
 * Edits an item.
 * @param _page The Playwright page.
 * @param _generated The generated item.
 * @param _generated.name The item name.
 * @param locator The locator.
 * @returns The updated item.
 */
async function editItem(
    _page: Page,
    _generated: { name: string },
    locator: Locator,
): Promise<{ name: string }> {
    const name = await fillText(locator, "Item");

    return { name };
}

/**
 * Tests the item creation, editing, and deletion.
 * @param page The Playwright page.
 * @returns The generated item.
 */
export async function testItem(page: Page): Promise<{ name: string }> {
    return await testEntity(
        page,
        "Items",
        "item",
        (_page) => createItem(page),
        checkResult,
        editItem,
    );
}
