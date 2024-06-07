//TODO: Test and fix testids
import { expect, Locator, Page } from "@playwright/test";
import { fillText, testEntity, testTitle } from "./common";

async function createItem(
    page: Page,
    aisleName: string,
    storeName: string,
    itemName: string,
) {
    await page
        .getByLabel(`Aisle`)
        .selectOption({ label: `${aisleName} (${storeName})` });
    await page.getByLabel(`Item`).selectOption({ label: `${itemName}` });
    await fillForm(page);
    return { name: storeName + aisleName + itemName };
}

async function fillForm(page: Page | Locator) {
    const price = Math.floor(Math.random() * 200);
    await page.getByLabel("Price").fill(price.toString());
    const size = Math.floor(Math.random() * 1000);
    await page.getByLabel("Size").fill(size.toString());
    const units = ["g", "kg", "mL", "L", "oz", "lb", "qt", "pt", "fl oz"][
        Math.floor(Math.random() * 9)
    ];
    await page.getByLabel("Units").selectOption({ label: units });
    const position = Math.floor(Math.random() * 99);
    await page.getByLabel("Position").fill(position.toString());
    const description = `Description ${Math.floor(Math.random() * 1000)}`;
    await page.getByLabel("Description").fill(description);
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
    await fillForm(locator);
    return { name };
}

export async function testAisleItem(
    page: Page,
    aisleName: string,
    storeName: string,
    itemName: string,
) {
    return await testEntity(
        page,
        "Aisle Items",
        "aisle-item",
        (page) => createItem(page, aisleName, storeName, itemName),
        checkResult,
        editItem,
    );
}
