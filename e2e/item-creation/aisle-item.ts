import { expect, Locator, Page } from "@playwright/test";
import { testEntity, testTitle } from "./common";
import { createHash } from "crypto";

async function createItem(
    page: Page,
    storeName: string,
    aisleName: string,
    itemName: string,
) {
    await expect(page.getByLabel(`Store`)).toBeVisible();
    await page.getByLabel(`Store`).selectOption({ label: `${storeName}` });
    await page.getByLabel(`Aisle`).selectOption({ label: `${aisleName}` });
    await page.getByLabel(`Item`).selectOption({ label: `${itemName}` });
    return await fillForm(page, aisleName, storeName, itemName);
}

async function fillForm(
    page: Page | Locator,
    aisleName: string,
    storeName: string,
    itemName: string,
) {
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
    return {
        name: createHash("md5")
            .update(`${storeName}${aisleName}${itemName}${description}`)
            .digest("hex"),
        titleOverride: description,
    };
}

const prefix = "aisle-item";

async function checkResult(
    page: Page,
    result: { name: string; titleOverride: string },
) {
    const { name, titleOverride } = result;
    await testTitle(page, prefix, name, {
        contentOverride: titleOverride,
    });
}

async function editItem(
    locator: Locator,
    aisleName: string,
    storeName: string,
    itemName: string,
) {
    return await fillForm(locator, storeName, aisleName, itemName);
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
        prefix,
        async (page) => await createItem(page, aisleName, storeName, itemName),
        checkResult,
        (page, generated, locator) =>
            editItem(locator, aisleName, storeName, itemName),
        true,
        {
            urlOverride: "aisle-items",
        },
    );
}
