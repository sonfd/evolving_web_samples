# Client Facing Documentation Sample

I wrote this documentation to describe an import/export exchange between the
website that we built and the client's "Data Vault," the original source for
most of the data. The site was a "Supplier" portal where folks in our client's
organization could browse a complete list of pre-approved outside vendors. Most
of this vendor data lived in an external source (called the "Data Vault") and
was used by other teams and systems. We synced this data from the source once a
day.

Additionally, the client's web team could add new information and override a few
fields directly in the site. This was for two reasons: some information was only
needed for the site and some of the source data was inaccurate. Because of this
ability to add / update data directly in the site, we also exported the data
once a day, just before performing the daily sync from the "Data Vault".

---

Note: this documentation was originally written in Notion and accessed via the
web. I exported it from Notion to an .md and its format was maintained, but I'm
flagging this detail because I wouldn't normally write client facing
documentation in a .md.
