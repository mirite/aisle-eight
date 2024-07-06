import { Locator, Page } from "@playwright/test";
import { fillText, testEntity, testTitle } from "./common";

async function createStore(page: Page) {
    const name = await fillText(page, "Store");
    return { name };
}

async function checkResult(page: Page, result: { name: string }) {
    const { name } = result;
    await testTitle(page, "store", name);
}

async function editStore(
    page: Page,
    generated: { name: string },
    locator: Locator,
) {
    const name = await fillText(locator, "Store");

    return { name };
}

export async function testStore(page: Page) {
    return await testEntity(
        page,
        "Stores",
        "store",
        (page) => createStore(page),
        checkResult,
        editStore,
    );
}
