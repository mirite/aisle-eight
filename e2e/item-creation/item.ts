import { Locator, Page } from "@playwright/test";
import { fillText, testEntity, testTitle } from "./common";

async function createItem(page: Page) {
    const name = await fillText(page, "Item");
    return { name };
}

async function checkResult(page: Page, result: { name: string }) {
    const { name } = result;
    await testTitle(page, "item", name);
}

async function editItem(
    page: Page,
    generated: { name: string },
    locator: Locator,
) {
    const name = await fillText(locator, "Item");

    return { name };
}

export async function testItem(page: Page) {
    return await testEntity(
        page,
        "Items",
        "item",
        (page) => createItem(page),
        checkResult,
        editItem,
    );
}
