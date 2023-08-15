# Description
**Introducing the Hipsy Events Plugin for Wordpress**

The Hipsy Events Plugin is a tool that seamlessly synchronizes events created on Hipsy.nl, with your WordPress website. With just a few simple steps, you can effortlessly connect your Hipsy account to your WordPress site and your events on Hipsy.nl will be synchronized with your website.

**The benefits of using the Hipsy Events Plugin:**

1. **Streamlined event management**: The plugin revolutionizes your event management workflow by eliminating the need for manual event creation in WordPress. Simply create events on Hipsy.nl, and they will automatically appear on your WordPress website, saving you valuable time and effort.

2. **Error-free synchronization**: Manual entry of events can lead to mistakes and inconsistencies. With the plugin's seamless synchronization, you can ensure that all event details, including dates, times, tickets, prices, descriptions, and images, are accurately transferred from Hipsy to your WordPress site, maintaining data integrity.

3. **Effortless updates**: Make changes to your events on Hipsy.nl, and rest assured that those updates will be automatically reflected on your WordPress website. Whether it's modifying event details, ticket prices, or availability, the plugin ensures that your website is always up-to-date with the latest information.


# Installation
This section describes how to install the plugin and get it working:
1. [`Download the plugin here`](https://github.com/hipsynl/hipsy-wordpress-events/releases/download/v1.0.0/hipsy-events.zip)
2. Login as administrator on your own Wordpress website
3. Navigate to *Plugins*, click *Add New* and then click *Upload Plugin* at the top of the page
4. Select and upload the .zip file you downloaded at step 1
5. Activate the plugin through the Plugins overview page

# Configuration

Once you've installed the plugin, you have to follow a few steps to configure your Hipsy account before you can publish your events on your website. To configure your Hipsy account your need to create an API key in the Hipsy dashboard.

1. Login to your [Hipsy dashboard](https://hipsy.nl/app)
2. Click on your organisation name and click on `Koppelingen`
3. Click on the green button 'Nieuwe API Key' to create a key and give it a name (e.g. My wordpress website).
4. Copy the generated key.
5. Navigate to your Wordpress admin panel and click in the menu at `Hipsy events` (only vissible once you've activated the plugin)
6. Click on Hipsy settings 
7. Paste the generated API key and click `Save settings`
8. Select to organisation of which you want to synchronize the events.

Once you've done those steps. The events are automatically synchronized and published on your website. Once you add or modify events on Hipsy.nl, at will also be added and modified on your website.

## Usage

### Events listing

If you have successfully installed and configured the plugin on your Wordpress website. An events link will be added
to your menu. This will navigate to a page which list all your upcoming events.

You are free to remove this link from your menu. Second option is to add the events listing on an existing page. Open the editor of this page and when adding a new block, search for the `Hipsy events list` block. 

### Manually add events

It is possible to manually add events to your Wordpress website which you didn't published on Hipsy. Click on the `Add event` menu (under Hipsy events) to add a new event only to your  Wordpress website.


# Frequently Asked Questions

### Q: What is an API key?

A: To make the synchronization process secure and convenient, the Hipsy Events Plugin utilizes an API key. An API key acts as a unique identifier that grants your WordPress website permission to access and interact with Hipsy. This secure integration ensures that your data remains protected while enabling seamless communication between platforms. You can [generate your API key here](https://hipsy.nl/app/api-keys).

### Q: What kind of support do you offer for the plugin?

A: We offer limited support for the plugin as it is provided free of charge. While we are committed to assisting our users, it's important to note that our resources are constrained, and we may not be able to address all individual queries promptly.

### Q: Where can I get help if I encounter issues with the plugin?

A: If you encounter any issues or have questions about the plugin, we encourage you to open an [issue on our GitHub repository](https://github.com/hipsynl/hipsy-wordpress-events/issues). This platform allows you to seek help from the broader community, including experienced users and developers who can share their insights and expertise.